<?php
include "BaseDAO.php";

class dataDashboard extends BaseDAO {
    function displayData() {
        // Map database categories to UI-friendly names
        $deviceMap = [
            'Server' => 'Server',
            'CPU' => 'CPU-PC',
            'Printer' => 'Printer',
            'UPS' => 'UPS',
            'Monitor' => 'Monitor',
            'Network Equipment - Switch' => 'Switch',
            'Network Equipment - Router ' => 'Router',
        ];

        // Allowed categories for the bar chart and table
        $allowedCategories = ['Server', 'CPU-PC', 'Printer', 'Monitor', 'Switch', 'Router', 'UPS'];

        $deviceCategoryCount = [];
        $allHardware = [];

        $this->openConn();
        $countDevice = $this->dbh->prepare("SELECT sub_major_type, hw_date_acq FROM hw_tbl WHERE hw_status = 'On Site'");
        $countDevice->execute();

        $ageData = [
            '3 Years below' => 0,
            '3-5 Years' => 0,
            '5-10 Years' => 0,
            '10 Years above' => 0
        ];
        $currentYear = date("Y");

        while ($row_data = $countDevice->fetch()) {
            $deviceCategoryName = $row_data['sub_major_type'];
            $uiCategory = isset($deviceMap[$deviceCategoryName]) ? $deviceMap[$deviceCategoryName] : $deviceCategoryName;

            // Keep all hardware for Age Chart
            $allHardware[] = [
                "sub_major_type" => $uiCategory,
                "hw_date_acq" => $row_data['hw_date_acq']
            ];

            // Ignore categories not in the allowed list for bar chart and table
            if (!in_array($uiCategory, $allowedCategories)) {
                continue;
            }

            if (!isset($deviceCategoryCount[$uiCategory])) {
                $deviceCategoryCount[$uiCategory] = 0;
            }
            $deviceCategoryCount[$uiCategory]++;

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
        $tableData = $this->fetchTableData();
        $filteredTableData = array_filter($tableData, function($item) {
            return !in_array($item['sub_major_type'], ['Server', 'CPU', 'Monitor', 'Network Equipment - Switch', 'Network Equipment - Router ', 'Printer']);
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
            COUNT(*) as count 
            FROM hw_tbl 
            WHERE sub_major_type = 'Server' 
            GROUP BY hw_model, hw_brand_name
        ");
        $server_model->execute();
            
        $serverModels = [];
        while ($row = $server_model->fetch()) {
            $serverModels[] = $row;
        }

        echo json_encode([
            "category_name" => array_keys($deviceCategoryCount),
            "category_count" => array_values($deviceCategoryCount),
            "age_labels" => array_keys($ageData),
            "age_data" => array_values($ageData),
            "hardware" => array_values($filteredTableData), // Filtered table data
            "all_hardware" => $allHardware, // Now includes ALL hardware for Age Chart filtering
            "server_models" => $serverModels // Include server models in JSON response
        ]);

        $this->closeConn();
    }

    private function fetchTableData() {
        $stmt = $this->dbh->prepare("SELECT sub_major_type, item_desc, COUNT(*) as count FROM hw_tbl WHERE hw_status = 'On Site' GROUP BY sub_major_type, item_desc");
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch()) {
            $data[] = $row;
        }

        return $data;
    }

}
