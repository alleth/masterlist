<?php
include "BaseDAO.php";

class viewServerSpecificRegionDAO extends BaseDAO{
    function viewServerSpecificRegion($region_name, $server_type)
    {

        $this->openConn();
        $stmt = "";

        if ($region_name == "all" && $server_type !== "all_server") {
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE item_desc = 'Server' AND hw_status = 'On Site' AND hw_brand_name = ? ORDER BY site_code");
            $stmt->bindParam(1, $server_type);
        } else {
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE item_desc = 'Server' AND region_name = ? AND hw_brand_name = ? AND item_desc = 'Server' AND hw_status = 'On Site' ORDER BY site_code");
            $stmt->bindParam(1, $region_name);
            $stmt->bindParam(2, $server_type);
        }
        $stmt->execute();

        $rows = $stmt->fetchAll(); // Fetch all results first
        foreach ($rows as $row) {
            // Fetch region name
            $region_stmt = $this->dbh->prepare("SELECT region_name FROM region_tbl WHERE region_id = ?");
            $region_stmt->bindParam(1, $row['region_name']);
            $region_stmt->execute();
            $region_data = $region_stmt->fetchColumn() ?: "Unidentified";

            $site_stmt = $this->dbh->prepare("SELECT site_name FROM site_list_tbl WHERE site_code = ?");
            $site_stmt->bindParam(1, $row['site_code']);
            $site_stmt->execute();
            $site_data = $site_stmt->fetchColumn() ?: "Unidentified";

            // Output table row with validation
            echo "<tr id='" . $row['hw_id'] . "'>";
            echo "<td>" . htmlspecialchars($region_data) . "</td>";
            echo "<td>" . (!empty($row['site_code']) ? htmlspecialchars($row['site_code']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($site_data) ? htmlspecialchars($site_data) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['hw_brand_name']) ? htmlspecialchars($row['hw_brand_name']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['hw_model']) ? htmlspecialchars($row['hw_model']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['hw_asset_num']) ? htmlspecialchars($row['hw_asset_num']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['hw_serial_num']) ? htmlspecialchars($row['hw_serial_num']) : "Unidentified") . "</td>";

            $purchase_date = $row['hw_date_acq']; // Retrieve date from database

            // Check if the purchase date is empty, '0000-00-00', or invalid
            if (empty($purchase_date) || $purchase_date == '0000-00-00' || strtotime($purchase_date) === false) {
                echo "<td>Unknown</td>"; // Display 'Unknown' for unidentified dates
            } else {
                $purchase_date = new DateTime($purchase_date);
                $current_date = new DateTime();
                $interval = $purchase_date->diff($current_date);

                echo "<td>" . $interval->y . " Years</td>"; // Display hardware age
            }
            echo "<td>" . (!empty($row['hw_status']) ? htmlspecialchars($row['hw_status']) : "Unidentified") . "</td>";
            echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='serverUpdate(" . $row['hw_id'] . ")'><span class='fas fa-edit'></span></button></td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}