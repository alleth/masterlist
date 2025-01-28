<?php
include "BaseDAO.php";

class addCPUDataDAO extends BaseDAO {
    function addCPUData(
        $region_name,
        $site_name,
        $site_code,
        $brand_name,
        $model_name,
        $asset_num,
        $serial_num,
        $hw_month,
        $hw_day,
        $hw_year,
        $status_option,
        $host_name,
        $ip_address,
        $mac_address,
        $user_name,
        $primary_role,
        $acquired_value
    ) {
        try {
            // Log incoming data for debugging
            error_log("Incoming Data: " . print_r([
                    'region_name' => $region_name,
                    'site_name' => $site_name,
                    'site_code' => $site_code,
                    'brand_name' => $brand_name,
                    'model_name' => $model_name,
                    'asset_num' => $asset_num,
                    'serial_num' => $serial_num,
                    'hw_month' => $hw_month,
                    'hw_day' => $hw_day,
                    'hw_year' => $hw_year,
                    'status_option' => $status_option,
                    'host_name' => $host_name,
                    'ip_address' => $ip_address,
                    'mac_address' => $mac_address,
                    'user_name' => $user_name,
                    'primary_role' => $primary_role,
                    'acquired_value' => $acquired_value,
                ], true));

            // Open Database Connection
            $this->openConn();

            // Validate Asset Number or Serial Number
            $stmt_check = $this->dbh->prepare("SELECT hw_asset_num, hw_serial_num FROM hw_tbl WHERE hw_asset_num = ? OR hw_serial_num = ?");
            $stmt_check->execute([$asset_num, $serial_num]);
            $existing = $stmt_check->fetch();

            if ($existing) {
                $this->closeConn();

                if ($existing['hw_asset_num'] === $asset_num) {
                    echo json_encode(["status" => "error", "message" => "Asset number already exists."]);
                    return;
                }

                if ($existing['hw_serial_num'] === $serial_num) {
                    echo json_encode(["status" => "error", "message" => "Serial number already exists."]);
                    return;
                }
            }

            // Fetch Region Name
            if (empty($region_name)) {
                throw new Exception("Region name is required.");
            }
            $region_details = $this->dbh->prepare("SELECT region_name FROM region_tbl WHERE region_id = ?");
            $region_details->execute([$region_name]);
            $region = $region_details->fetchColumn();
            if (!$region) {
                throw new Exception("Invalid region ID.");
            }

            // Fetch Site Name
            if (empty($site_name)) {
                throw new Exception("Site name is required.");
            }
            $site_details = $this->dbh->prepare("SELECT site_name FROM site_list_tbl WHERE site_id = ?");
            $site_details->execute([$site_name]);
            $site = $site_details->fetchColumn();
            if (!$site) {
                throw new Exception("Invalid site ID.");
            }

            // Validate Brand Name and Model Name
            if (empty($brand_name)) {
                throw new Exception("Brand name is required.");
            }
            if (empty($model_name)) {
                throw new Exception("Model name is required.");
            }

            // Insert the Hardware Data
            $stmt_insert = $this->dbh->prepare("
                INSERT INTO hw_tbl (
                    region_name, site_code, site_name, hw_brand_name, hw_model, hw_asset_num, 
                    hw_serial_num, hw_month_acq, hw_day_acq, hw_year_acq, hw_status, 
                    hw_host_name, hw_ip_add, hw_mac_add, hw_user_name, hw_primary_role, hw_acq_val
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $result = $stmt_insert->execute([
                $region,
                $site_code,
                $site,
                $brand_name,
                $model_name,
                $asset_num,
                $serial_num,
                $hw_month,
                $hw_day,
                $hw_year,
                $status_option,
                $host_name,
                $ip_address,
                $mac_address,
                $user_name,
                $primary_role,
                $acquired_value,
            ]);

            // Close Database Connection
            $this->closeConn();

            // Response
            if ($result) {
                echo json_encode(["status" => "success", "message" => "Hardware data added successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add hardware data."]);
            }
        } catch (Exception $e) {
            // Handle Errors
            $this->closeConn();
            error_log("Error: " . $e->getMessage());
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
