<?php
include "BaseDAO.php";

class dataDashboard extends BaseDAO {
    function displayData() {
        // ✅ New conditional block for hardware_deployment filtering
        if (isset($_POST['action']) && $_POST['action'] === 'hardware_deployment') {
            $hardware = isset($_POST['hardware']) ? $_POST['hardware'] : 'all';
            $params = [];
            $hardwareCondition = "";

            if ($hardware !== 'all') {
                $hardwareCondition = "AND sub_major_type = :hardware";
                $params[':hardware'] = $hardware;
            }

            $this->openConn();
            $stmt = $this->dbh->prepare("
                SELECT 
                    COALESCE(r.region_name, 'Unknown') AS region,
                    COUNT(*) AS deployment_count
                FROM hw_tbl h
                LEFT JOIN region_tbl r ON h.region_name = r.region_id
                WHERE h.hw_status = 'On Site' $hardwareCondition
                GROUP BY r.region_name
                ORDER BY LENGTH(r.region_name), r.region_name
            ");
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeConn();

            $labels = [];
            $counts = [];
            foreach ($result as $row) {
                $labels[] = $row['region'];
                $counts[] = (int)$row['deployment_count'];
            }

            echo json_encode([
                "labels" => $labels,
                "data" => $counts
            ]);
            exit;
        }

        // 🔽 Original logic continues here...
        $region = isset($_POST['region']) ? $_POST['region'] : 'all';
        $params = [];
        $regionCondition = "";

        $regionMap = [
            '1' => '1', '2' => '2', '3' => '3', '4' => '4',
            '5' => '5', '6' => '6', '7' => '7', '8' => '8',
            '9' => '9', '10' => '10', '11' => '11', '12' => '12',
            '13' => '13', '14' => '14', '15' => '15', '16' => '16',
            '17' => '17'
        ];

        if ($region !== 'all') {
            $mappedRegion = isset($regionMap[$region]) ? $regionMap[$region] : $region;
            $regionCondition = " AND region_name = :region";
            $params[':region'] = $mappedRegion;
        }

        $deviceMap = [
            'SERVER' => 'Server', 'CPU-PC' => 'CPU-PC', 'Printer' => 'Printer',
            'UPS-SERVER' => 'UPS-SERVER', 'UPS-PC' => 'UPS-PC', 'Monitor' => 'Monitor',
            'Peripherals' => 'Peripherals', 'Network Equipment' => 'Network Equipment'
        ];
        $allowedCategories = array_values($deviceMap);

        $this->openConn();

        $countDevice = $this->dbh->prepare("SELECT sub_major_type, hw_date_acq FROM hw_tbl WHERE hw_status = 'On Site' $regionCondition");
        $countDevice->execute($params);
        $hardwareRows = $countDevice->fetchAll(PDO::FETCH_ASSOC);

        $allHardware = [];
        $ageData = [
            '3 Years below' => 0, '3-5 Years' => 0, '5-10 Years' => 0,
            '10 Years above' => 0, 'Unidentified Age' => 0
        ];
        $currentYear = date("Y");

        foreach ($hardwareRows as $row_data) {
            $uiCategory = isset($deviceMap[$row_data['sub_major_type']]) ? $deviceMap[$row_data['sub_major_type']] : $row_data['sub_major_type'];

            $allHardware[] = [
                "sub_major_type" => $uiCategory,
                "hw_date_acq" => $row_data['hw_date_acq']
            ];

            if (empty($row_data['hw_date_acq']) || strtotime($row_data['hw_date_acq']) === false) {
                $ageData['Unidentified Age']++;
                continue;
            }

            $yearAcq = date("Y", strtotime($row_data['hw_date_acq']));
            $age = $currentYear - $yearAcq;
            if ($age <= 3) $ageData['3 Years below']++;
            elseif ($age <= 5) $ageData['3-5 Years']++;
            elseif ($age <= 10) $ageData['5-10 Years']++;
            else $ageData['10 Years above']++;
        }

        $tableData = $this->fetchTableData($regionCondition, $params);
        $filteredTableData = array_filter($tableData, function($item) use ($allowedCategories) {
            return !in_array($item['sub_major_type'], $allowedCategories);
        });

        $server_model = $this->dbh->prepare("
            SELECT 
                CASE WHEN TRIM(hw_model) = '' OR hw_model IS NULL THEN 'Unknown Model' ELSE hw_model END AS hw_model,
                CASE WHEN TRIM(hw_brand_name) = '' OR hw_brand_name IS NULL THEN 'Unknown Brand' ELSE hw_brand_name END AS hw_brand_name,
                COUNT(*) AS count 
            FROM hw_tbl 
            WHERE sub_major_type = 'Server' AND hw_status = 'On Site' $regionCondition
            GROUP BY hw_model, hw_brand_name
            ORDER BY count DESC
        ");
        $server_model->execute($params);
        $serverModels = $server_model->fetchAll(PDO::FETCH_ASSOC);

        $printer_model = $this->dbh->prepare("
            SELECT 
                CASE WHEN TRIM(hw_model) = '' OR hw_model IS NULL THEN 'Unknown Model' ELSE hw_model END AS hw_model,
                CASE WHEN TRIM(hw_brand_name) = '' OR hw_brand_name IS NULL THEN 'Unknown Brand' ELSE hw_brand_name END AS hw_brand_name,
                COUNT(*) AS count 
            FROM hw_tbl 
            WHERE sub_major_type = 'Printer' AND hw_status = 'On Site' $regionCondition
            GROUP BY hw_model, hw_brand_name
            ORDER BY count DESC
        ");
        $printer_model->execute($params);
        $printerModels = $printer_model->fetchAll(PDO::FETCH_ASSOC);

        $os_type = $this->dbh->prepare("
            SELECT 
                CASE WHEN TRIM(os_type) = '' OR os_type IS NULL THEN 'Unknown OS' ELSE os_type END AS os_type,
                COUNT(*) AS count 
            FROM hw_tbl 
            WHERE sub_major_type = 'CPU-PC' AND hw_status = 'On Site' $regionCondition
            GROUP BY os_type
            ORDER BY count DESC
        ");
        $os_type->execute($params);
        $osType = $os_type->fetchAll(PDO::FETCH_ASSOC);

        $deploymentQuery = $this->dbh->prepare("
            SELECT 
                COALESCE(r.region_name, 'Unknown') AS region,
                COUNT(*) AS deployment_count
            FROM hw_tbl h
            LEFT JOIN region_tbl r ON h.region_name = r.region_id
            WHERE h.hw_status = 'On Site'
            GROUP BY r.region_name
            ORDER BY r.region_id
        ");
        $deploymentQuery->execute();
        $deploymentResults = $deploymentQuery->fetchAll(PDO::FETCH_ASSOC);

        $regionLabels = [];
        $regionCounts = [];
        foreach ($deploymentResults as $row) {
            $regionLabels[] = $row['region'];
            $regionCounts[] = $row['deployment_count'];
        }

        $this->closeConn();

        $response = [
            "category_name" => $regionLabels,
            "category_count" => $regionCounts,
            "age_labels" => array_keys($ageData),
            "age_data" => array_values($ageData),
            "hardware" => array_values($filteredTableData),
            "all_hardware" => $allHardware,
            "server_models" => $serverModels,
            "printer_models" => $printerModels,
            "os_type" => $osType
        ];

        echo json_encode($response);
    }

    private function fetchTableData($regionCondition = "", $params = []) {
        $query = "SELECT sub_major_type, item_desc, COUNT(*) as count 
                  FROM hw_tbl 
                  WHERE hw_status = 'On Site' $regionCondition 
                  GROUP BY sub_major_type, item_desc";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
