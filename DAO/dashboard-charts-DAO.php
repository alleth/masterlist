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

        // Only keep these categories
        $allowedCategories = ['Server', 'CPU-PC', 'Printer', 'Monitor', 'Switch', 'Router', 'UPS'];

        $deviceCategoryCount = [];

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

            // Ignore categories not in the allowed list
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

        // Fetch data for tables
        $tableData = $this->fetchTableData();

        // Filter out the specified sub_major_type values for the table only
        $filteredTableData = array_filter($tableData, function($item) {
            return !in_array($item['sub_major_type'], ['Server', 'CPU', 'Monitor', 'Network Equipment - Switch', 'Network Equipment - Router ', 'Printer']);
        });

        echo json_encode([
            "category_name" => array_keys($deviceCategoryCount),
            "category_count" => array_values($deviceCategoryCount),
            "age_labels" => array_keys($ageData),
            "age_data" => array_values($ageData),
            "hardware" => array_values($filteredTableData), // Re-index the array
            "all_hardware" => $tableData // Include all hardware data for charts
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
?>
