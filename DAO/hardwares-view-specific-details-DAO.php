<?php
include "BaseDAO.php";

class viewSpecificDetailsDAO extends BaseDAO {
    function viewSpecificDetails($site_name, $hw_type, $region_name = null) {
        $this->openConn();

        // Validate inputs
        if (empty($hw_type) || $hw_type === 'all_hw' || !is_string($hw_type)) {
            error_log("Invalid hw_type: " . ($hw_type ?? 'null'));
            echo "<tr><td colspan='8' class='text-center'>Invalid hardware type selected</td></tr>";
            $this->closeConn();
            return;
        }
        if ($region_name !== 'all_region' && (empty($region_name) || !is_string($region_name))) {
            error_log("Invalid region_name: " . ($region_name ?? 'null'));
            echo "<tr><td colspan='8' class='text-center'>Invalid region selected</td></tr>";
            $this->closeConn();
            return;
        }
        if ($site_name !== 'all_sites' && (empty($site_name) || !is_string($site_name))) {
            error_log("Invalid site_name: " . ($site_name ?? 'null'));
            echo "<tr><td colspan='8' class='text-center'>Invalid site selected</td></tr>";
            $this->closeConn();
            return;
        }

        // Check database connection
        try {
            $this->dbh->query("SELECT 1");
            error_log("Database connection successful for viewSpecificDetails");
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            echo "<tr><td colspan='8' class='text-center'>Database connection error</td></tr>";
            $this->closeConn();
            return;
        }

        // Check table existence
        try {
            $tables = ['hw_tbl', 'site_list_tbl'];
            foreach ($tables as $table) {
                $stmt = $this->dbh->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() === 0) {
                    error_log("Table $table does not exist");
                    echo "<tr><td colspan='8' class='text-center'>Database table $table not found</td></tr>";
                    $this->closeConn();
                    return;
                }
            }
            error_log("All required tables exist: " . implode(', ', $tables));
        } catch (PDOException $e) {
            error_log("Error checking table existence: " . $e->getMessage());
            echo "<tr><td colspan='8' class='text-center'>Database error checking tables</td></tr>";
            $this->closeConn();
            return;
        }

        // Check column existence
        try {
            $stmt = $this->dbh->query("DESCRIBE hw_tbl");
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $required_columns = ['hw_id', 'region_name', 'site_code', 'item_desc', 'hw_brand_name', 'hw_model', 'hw_asset_num', 'hw_serial_num', 'hw_date_acq', 'hw_status', 'sub_major_type'];
            $missing_columns = array_diff($required_columns, $columns);
            if (!empty($missing_columns)) {
                error_log("Missing columns in hw_tbl: " . implode(', ', $missing_columns));
                echo "<tr><td colspan='8' class='text-center'>Missing database columns: " . implode(', ', $missing_columns) . "</td></tr>";
                $this->closeConn();
                return;
            }
            error_log("All required columns exist in hw_tbl: " . implode(', ', $required_columns));
        } catch (PDOException $e) {
            error_log("Error checking hw_tbl columns: " . $e->getMessage());
            echo "<tr><td colspan='8' class='text-center'>Error checking table structure</td></tr>";
            $this->closeConn();
            return;
        }

        // Debug data in hw_tbl
        try {
            $debug_region = $region_name ?: 'all_region';
            $debug_site = $site_name ?: 'all_sites';
            $debug_hw_type = $hw_type;
            $debug_query = "SELECT COUNT(*) as count FROM hw_tbl WHERE hw_status = 'On Site'";
            $debug_params = [];
            if ($debug_region !== 'all_region') {
                $debug_query .= " AND TRIM(LOWER(region_name)) = TRIM(LOWER(?))";
                $debug_params[] = $debug_region;
            }
            if ($debug_site !== 'all_sites') {
                $debug_query .= " AND TRIM(LOWER(site_code)) = TRIM(LOWER(?))";
                $debug_params[] = $debug_site;
            }
            $debug_query .= " AND TRIM(LOWER(sub_major_type)) = TRIM(LOWER(?))";
            $debug_params[] = $debug_hw_type;

            $debug_stmt = $this->dbh->prepare($debug_query);
            foreach ($debug_params as $index => $param) {
                $debug_stmt->bindParam($index + 1, $param);
            }
            $debug_stmt->execute();
            $debug_result = $debug_stmt->fetch(PDO::FETCH_ASSOC);
            error_log("Debug: Found {$debug_result['count']} rows in hw_tbl for region_name='$debug_region', site_code='$debug_site', hw_type='$debug_hw_type', hw_status='On Site'");
        } catch (PDOException $e) {
            error_log("Error debugging hw_tbl data: " . $e->getMessage());
        }

        $query = "SELECT hw_id, region_name, site_code, item_desc, hw_brand_name, hw_model, hw_asset_num, hw_serial_num, hw_date_acq, hw_status 
                  FROM hw_tbl WHERE hw_status = 'On Site'";
        $params = [];

        if ($region_name !== 'all_region' && !empty($region_name)) {
            $query .= " AND TRIM(LOWER(region_name)) = TRIM(LOWER(?))";
            $params[] = $region_name;
        }
        if ($site_name !== 'all_sites' && !empty($site_name)) {
            $query .= " AND TRIM(LOWER(site_code)) = TRIM(LOWER(?))";
            $params[] = $site_name;
        }
        if (!empty($hw_type)) {
            $query .= " AND TRIM(LOWER(sub_major_type)) = TRIM(LOWER(?))";
            $params[] = $hw_type;
        }

        $query .= " ORDER BY item_desc";

        error_log("Executing query: $query with params: " . json_encode($params));

        try {
            $stmt = $this->dbh->prepare($query);
            foreach ($params as $index => $param) {
                $stmt->bindParam($index + 1, $param);
            }
            $stmt->execute();

            $row_count = $stmt->rowCount();
            error_log("Query returned $row_count rows for site_name: " . ($site_name ?? 'null') . ", hw_type: " . ($hw_type ?? 'null') . ", region_name: " . ($region_name ?? 'null'));

            ob_start();
            if ($row_count === 0) {
                echo "<tr><td colspan='8' class='text-center'>No hardware found</td></tr>";
            } else {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    error_log("Processing row: " . json_encode($row));

                    // Use region_name directly from hw_tbl
                    $region_name_val = htmlspecialchars($row['region_name'] ?? 'N/A');

                    // Fetch site name
                    $site_name_val = 'N/A';
                    if (!empty($row['site_code'])) {
                        try {
                            $site_stmt = $this->dbh->prepare("SELECT site_name FROM site_list_tbl WHERE TRIM(LOWER(site_code)) = TRIM(LOWER(?))");
                            $site_stmt->bindParam(1, $row['site_code']);
                            $site_stmt->execute();
                            $get_site = $site_stmt->fetch(PDO::FETCH_ASSOC);
                            $site_name_val = $get_site['site_name'] ?? 'N/A';
                        } catch (PDOException $e) {
                            error_log("Error fetching site_name for site_code {$row['site_code']}: " . $e->getMessage());
                            $site_name_val = 'N/A';
                        }
                    }

                    echo "<tr id='" . htmlspecialchars($row['hw_id'] ?? '') . "'>";
                    echo "<td>" . $region_name_val . "</td>";
                    echo "<td>" . htmlspecialchars(($row['site_code'] ?? '') . " – " . $site_name_val) . "</td>";
                    echo "<td>" . htmlspecialchars($row['item_desc'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['hw_brand_name'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['hw_model'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['hw_asset_num'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['hw_serial_num'] ?? 'N/A') . "</td>";
                    echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm edit-hardware-btn' data-hw-id='" . htmlspecialchars($row['hw_id'] ?? '') . "'><span class='fas fa-edit'></span></button></td>";
                    echo "</tr>";
                }
            }
            $output = ob_get_clean();
            error_log("DAO output: " . $output);
            echo $output;
        } catch (PDOException $e) {
            error_log("Database error in query execution: " . $e->getMessage() . " | Query: $query | Params: " . json_encode($params));
            $output = "<tr><td colspan='8' class='text-center'>Error retrieving hardware data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            error_log("DAO output: " . $output);
            echo $output;
        }

        $this->closeConn();
    }
}