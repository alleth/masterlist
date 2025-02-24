<?php
include "BaseDAO.php";

class dataDashboard extends BaseDAO {
    function displayData() {
        // Read region filter from POST (default to 'all')
        $region = isset($_POST['region']) ? $_POST['region'] : 'all';
        $regionCondition = "";
        $params = [];
        if ($region !== 'all') {
            $regionCondition = " AND region_name = :region";
            $params[':region'] = $region;
        }

        // Map database categories to UI-friendly names
        $deviceMap = [
            'SERVER'            => 'Server',
            'CPU-PC'            => 'CPU-PC',
            'Printer'           => 'Printer',
            'UPS-SERVER'        => 'UPS-SERVER',
            'UPS-PC'            => 'UPS-PC',
            'Monitor'           => 'Monitor',
            'Peripherals'       => 'Peripherals',
            'Network Equipment' => 'Network Equipment'
        ];

        // Allowed categories for the bar chart and table
        $allowedCategories = ['Server', 'CPU-PC', 'Printer', 'Monitor', 'Network Equipment', 'Peripherals', 'UPS-SERVER', 'UPS-PC'];

        $deviceCategoryCount = [];
        $allHardware = [];

        $this->openConn();
        // Update query to include region filtering
        $countDevice = $this->dbh->prepare("SELECT sub_major_type, hw_date_acq FROM hw_tbl WHERE hw_status = 'On Site' $regionCondition");
        $countDevice->execute($params);

        // Added 'Unidentified Age' key here
        $ageData = [
            '3 Years below'  => 0,
            '3-5 Years'       => 0,
            '5-10 Years'      => 0,
            '10 Years above'  => 0,
            'Unidentified Age'=> 0
        ];
        $currentYear = date("Y");

        while ($row_data = $countDevice->fetch()) {
            $deviceCategoryName = $row_data['sub_major_type'];
            $uiCategory = isset($deviceMap[$deviceCategoryName]) ? $deviceMap[$deviceCategoryName] : $deviceCategoryName;

            // Process only allowed categories
            if (!in_array($uiCategory, $allowedCategories)) {
                continue;
            }

            // Keep only allowed hardware for Age Chart (for consistency)
            $allHardware[] = [
                "sub_major_type" => $uiCategory,
                "hw_date_acq"    => $row_data['hw_date_acq']
            ];

            // Build device category count for bar chart
            if (!isset($deviceCategoryCount[$uiCategory])) {
                $deviceCategoryCount[$uiCategory] = 0;
            }
            $deviceCategoryCount[$uiCategory]++;

            // Check if acquisition date is empty or invalid
            if (empty($row_data['hw_date_acq']) || strtotime($row_data['hw_date_acq']) === false) {
                $ageData['Unidentified Age']++;
                continue;
            }

            // Calculate age of hardware
            $yearAcq = date("Y", strtotime($row_data['hw_date_acq']));
            $age = $currentYear - $yearAcq;

            if ($age <= 3) {
                $ageData['3 Years below']++;
            } elseif ($age <= 5) {
                $ageData['3-5 Years']++;
            } elseif ($age <= 10) {
                $ageData['5-10 Years']++;
            } else {
                $ageData['10 Years above']++;
            }
        }

        // Fetch data for tables (this remains filtered)
        $tableData = $this->fetchTableData($regionCondition, $params);
        $filteredTableData = array_filter($tableData, function($item) {
            return !in_array($item['sub_major_type'], ['Server', 'CPU-PC', 'Monitor', 'Network Equipment', 'Printer', 'UPS-SERVER', 'UPS-PC', 'Peripherals']);
        });

        // Fetch Server Models Count
        $server_model = $this->dbh->prepare("
            SELECT 
                CASE 
                    WHEN TRIM(hw_model) = '' OR hw_model IS NULL THEN 'Unknown Model' 
                    ELSE hw_model 
                END AS hw_model,
                CASE 
                    WHEN TRIM(hw_brand_name) = '' OR hw_brand_name IS NULL THEN 'Unknown Brand' 
                    ELSE hw_brand_name 
                END AS hw_brand_name,
                COUNT(*) AS count 
            FROM hw_tbl 
            WHERE sub_major_type = 'Server'
              AND hw_status = 'On Site'
              $regionCondition
            GROUP BY hw_model, hw_brand_name
            ORDER BY count DESC;
        ");
        $server_model->execute($params);

        $serverModels = [];
        while ($server_row = $server_model->fetch()) {
            $serverModels[] = $server_row;
        }

        // Fetch Printer Models Count
        $printer_model = $this->dbh->prepare("
            SELECT 
                CASE 
                    WHEN TRIM(hw_model) = '' OR hw_model IS NULL THEN 'Unknown Model' 
                    ELSE hw_model 
                END AS hw_model,
                CASE 
                    WHEN TRIM(hw_brand_name) = '' OR hw_brand_name IS NULL THEN 'Unknown Brand' 
                    ELSE hw_brand_name 
                END AS hw_brand_name,
                COUNT(*) AS count 
            FROM hw_tbl 
            WHERE sub_major_type = 'Printer'
              AND hw_status = 'On Site'
              $regionCondition
            GROUP BY hw_model, hw_brand_name
            ORDER BY count DESC;
        ");
        $printer_model->execute($params);

        $printerModels = [];
        while ($printer_row = $printer_model->fetch()) {
            $printerModels[] = $printer_row;
        }

        // Fetch OS Type Count
        $os_type = $this->dbh->prepare("
            SELECT 
                CASE 
                    WHEN TRIM(os_type) = '' OR os_type IS NULL THEN 'Unknown OS' 
                    ELSE os_type 
                END AS os_type,
                COUNT(*) AS count 
            FROM hw_tbl 
            WHERE sub_major_type = 'CPU-PC'
              AND hw_status = 'On Site'
              $regionCondition
            GROUP BY os_type
            ORDER BY count DESC;
        ");
        $os_type->execute($params);

        $osType = [];
        while ($os_row = $os_type->fetch()) {
            $osType[] = $os_row;
        }

        // Additional query for switch ports (if needed)
        $nodes_av = $this->dbh->prepare("SELECT ports_num, ports_working, ports_deffect FROM hw_tbl WHERE item_desc = 'Switch'");
        $nodes_av->execute();

        echo json_encode([
            "category_name"   => array_keys($deviceCategoryCount),
            "category_count"  => array_values($deviceCategoryCount),
            "age_labels"      => array_keys($ageData),
            "age_data"        => array_values($ageData),
            "hardware"        => array_values($filteredTableData), // Filtered table data
            "all_hardware"    => $allHardware, // Now includes only allowed hardware for Age Chart filtering
            "server_models"   => $serverModels,
            "printer_models"  => $printerModels,
            "os_type"         => $osType
        ]);

        $this->closeConn();
    }

    private function fetchTableData($regionCondition = "", $params = []) {
        $query = "SELECT sub_major_type, item_desc, COUNT(*) as count FROM hw_tbl WHERE hw_status = 'On Site' $regionCondition GROUP BY sub_major_type, item_desc";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($params);

        $data = [];
        while ($row = $stmt->fetch()) {
            $data[] = $row;
        }

        return $data;
    }
}
