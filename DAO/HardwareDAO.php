<?php
require_once 'BaseDAO.php';

class HardwareDAO extends BaseDAO
{
    public function getRegions()
    {
        try {
            $this->openConn();
            $conn = $this->dbh;
            error_log("Executing getRegions query");
            $query = "SELECT region_id, region_name FROM region_tbl ORDER BY region_id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("getRegions: Found " . count($regions) . " regions");
            $this->closeConn();
            return $regions;
        } catch (PDOException $e) {
            error_log("getRegions error: " . $e->getMessage());
            $this->closeConn();
            return ['error' => 'Database query failed (regions): ' . $e->getMessage()];
        }
    }

    public function getSites($region_id)
    {
        try {
            if (empty($region_id)) {
                error_log("getSites: Missing region_id");
                return ['error' => 'Region ID is required'];
            }
            $this->openConn();
            $conn = $this->dbh;
            error_log("Executing getSites query for region_id=$region_id");
            $query = "SELECT DISTINCT s.site_code, s.site_name 
                      FROM site_list_tbl s
                      JOIN hw_tbl h ON s.site_code = h.site_code
                      WHERE CAST(s.region_id AS SIGNED) = ? 
                      ORDER BY s.site_code";
            $stmt = $conn->prepare($query);
            $stmt->execute([$region_id]);
            $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("getSites: Found " . count($sites) . " sites for region_id=$region_id: " . json_encode($sites));
            $this->closeConn();
            return $sites;
        } catch (PDOException $e) {
            error_log("getSites error: " . $e->getMessage());
            $this->closeConn();
            return ['error' => 'Database query failed (sites): ' . $e->getMessage()];
        }
    }

    public function getSiteCounts($params = []) {
        try {
            $this->openConn();
            $conn = $this->dbh;
            $response = [];
            $where = "WHERE 1=1";
            $whereParams = [];

            // Region filter
            if (!empty($params['region_id'])) {
                $where .= " AND region_id = ?";
                $whereParams[] = $params['region_id'];
                error_log("Applying region filter: region_id=" . $params['region_id']);
            }

            // Site filter
            if (!empty($params['site_code']) && $params['site_code'] !== '0') {
                $query = "SELECT office_type, site_partnership 
                          FROM site_list_tbl 
                          WHERE site_code = ? AND region_id = ?";
                $whereParams = [$params['site_code'], $params['region_id']];
                error_log("Executing office_type query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                error_log("Office type result: " . json_encode($result));
                $this->closeConn();
                return [
                    'office_type' => $result['office_type'] ?: 'Unknown',
                    'site_partnership' => $result['site_partnership'] ?: 'Unknown'
                ];
            }

            // Total sites
            $query = "SELECT COUNT(DISTINCT site_code) as total_sites 
                      FROM site_list_tbl $where";
            error_log("Executing total sites query: $query with params: " . json_encode($whereParams));
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $totalSites = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total_sites'];
            error_log("Total sites result: $totalSites");
            $response['total_sites'] = $totalSites;

            // Proponent count
            $query = "SELECT COUNT(DISTINCT site_code) as count 
                      FROM site_list_tbl $where AND site_partnership = 'Proponent'";
            error_log("Executing proponent count query: $query with params: " . json_encode($whereParams));
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $proponentCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
            error_log("Proponent count result: $proponentCount");
            $response['proponent_count'] = $proponentCount;

            // Government count
            $query = "SELECT COUNT(DISTINCT site_code) as count 
                      FROM site_list_tbl $where AND site_partnership = 'Government'";
            error_log("Executing government count query: $query with params: " . json_encode($whereParams));
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $governmentCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
            error_log("Government count result: $governmentCount");
            $response['government_count'] = $governmentCount;

            $this->closeConn();
            error_log("Returning site counts: " . json_encode($response));
            return $response;
        } catch (PDOException $e) {
            error_log("getSiteCounts error: " . $e->getMessage());
            $this->closeConn();
            return ['error' => 'Database query failed (site counts): ' . $e->getMessage()];
        }
    }
    public function getHardwareCounts($params = [])
    {
        try {
            $this->openConn();
            $conn = $this->dbh;
            $response = [
                'total' => 0,
                'servers' => ['total' => 0, 'brands' => [], 'os' => []],
                'workstations' => ['total' => 0, 'brands' => [], 'os' => []],
                'printers' => ['total' => 0, 'brands' => []],
                'peripherals' => [
                    'total' => 0,
                    'categories' => [],
                    'webcam_brands' => [],
                    'sigpad_brands' => [],
                    'pos_brands' => [],
                    'lcd_brands' => [],
                    'cashdrawer_brands' => []
                ],
                'network_equipment' => [
                    'total' => 0,
                    'categories' => []
                ]
            ];

            // Base WHERE clause
            $where = "WHERE h.hw_status = 'On Site'";
            $whereParams = [];

            // Region filter
            if (!empty($params['region_id'])) {
                $where .= " AND h.region_name = (SELECT region_id FROM region_tbl WHERE region_id = ?)";
                $whereParams[] = $params['region_id'];
                error_log("Applying region filter: region_id=" . $params['region_id']);
            }

            // Site filter
            if (!empty($params['site_code']) && $params['site_code'] !== '0') {
                $where .= " AND h.site_code = ?";
                $whereParams[] = $params['site_code'];
                error_log("Applying site filter: site_code=" . $params['site_code']);
            }

            // Log hw_tbl contents
            $debugQuery = "SELECT DISTINCT h.region_name, h.site_code, h.hw_status FROM hw_tbl h";
            $stmt = $conn->prepare($debugQuery);
            $stmt->execute();
            $hwData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("hw_tbl data: " . json_encode($hwData));

            // Total count
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where";
            try {
                error_log("Executing total count query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
                error_log("Total count result: $total");
                $response['total'] = $total;
            } catch (PDOException $e) {
                error_log("Total count query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (total count): ' . $e->getMessage()];
            }

            // Servers
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where AND (LOWER(h.sub_major_type) LIKE 'server' OR LOWER(h.item_desc) LIKE 'server')";
            try {
                error_log("Executing server total query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
                error_log("Server total result: $total");
                $response['servers']['total'] = $total;
            } catch (PDOException $e) {
                error_log("Server total query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (servers total): ' . $e->getMessage()];
            }

            // Server Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where AND (LOWER(h.sub_major_type) LIKE 'server' OR LOWER(h.item_desc) LIKE 'server') 
                      GROUP BY h.hw_brand_name, h.hw_model, h.os_type 
                      ORDER BY count DESC";
            try {
                error_log("Executing server brands query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Server brands result: " . json_encode($rows));
                $brands = [];
                foreach ($rows as $row) {
                    $brandName = $row['brand'] ?: 'Unknown';
                    if (!isset($brands[$brandName])) {
                        $brands[$brandName] = [
                            'brand' => $brandName,
                            'models' => []
                        ];
                    }
                    $brands[$brandName]['models'][] = [
                        'model' => $row['model'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
                $response['servers']['brands'] = array_values($brands);
            } catch (PDOException $e) {
                error_log("Server brands query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (server brands): ' . $e->getMessage()];
            }

            // Server OS
            $query = "SELECT h.os_type as name, COUNT(*) as count 
                      FROM hw_tbl h $where AND (LOWER(h.sub_major_type) LIKE 'server' OR LOWER(h.item_desc) LIKE 'server') 
                      GROUP BY h.os_type 
                      ORDER BY count DESC";
            try {
                error_log("Executing server OS query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Server OS result: " . json_encode($rows));
                foreach ($rows as $row) {
                    $response['servers']['os'][] = [
                        'name' => $row['name'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
            } catch (PDOException $e) {
                error_log("Server OS query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (server OS): ' . $e->getMessage()];
            }

            // Workstations
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'CPU-PC'";
            try {
                error_log("Executing workstation total query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
                error_log("Workstation total result: $total");
                $response['workstations']['total'] = $total;
            } catch (PDOException $e) {
                error_log("Workstation total query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (workstations total): ' . $e->getMessage()];
            }

            // Workstation Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'CPU-PC' 
                      GROUP BY h.hw_brand_name, h.hw_model 
                      ORDER BY count DESC";
            try {
                error_log("Executing workstation brands query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Workstation brands result: " . json_encode($rows));
                $brands = [];
                foreach ($rows as $row) {
                    $brandName = $row['brand'] ?: 'Unknown';
                    if (!isset($brands[$brandName])) {
                        $brands[$brandName] = [
                            'brand' => $brandName,
                            'models' => []
                        ];
                    }
                    $brands[$brandName]['models'][] = [
                        'model' => $row['model'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
                $response['workstations']['brands'] = array_values($brands);
            } catch (PDOException $e) {
                error_log("Workstation brands query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (workstation brands): ' . $e->getMessage()];
            }

            // Workstation OS
            $query = "SELECT h.os_type as name, COUNT(*) as count 
                      FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'CPU-PC' 
                      GROUP BY h.os_type 
                      ORDER BY count DESC";
            try {
                error_log("Executing workstation OS query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Workstation OS result: " . json_encode($rows));
                foreach ($rows as $row) {
                    $response['workstations']['os'][] = [
                        'name' => $row['name'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
            } catch (PDOException $e) {
                error_log("Workstation OS query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (workstation OS): ' . $e->getMessage()];
            }

            // Printers
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE '%printer%'";
            try {
                error_log("Executing printer total query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
                error_log("Printer total result: $total");
                $response['printers']['total'] = $total;
            } catch (PDOException $e) {
                error_log("Printer total query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (printers total): ' . $e->getMessage()];
            }

            // Printer Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, h.item_desc as printer_type, COUNT(*) as count 
                      FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE '%printer%' 
                      GROUP BY h.hw_brand_name, h.hw_model, h.item_desc 
                      ORDER BY count DESC";
            try {
                error_log("Executing printer brands query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Printer brands result: " . json_encode($rows));
                $brands = [];
                foreach ($rows as $row) {
                    $brandName = $row['brand'] ?: 'Unknown';
                    if (!isset($brands[$brandName])) {
                        $brands[$brandName] = [
                            'brand' => $brandName,
                            'models' => []
                        ];
                    }
                    $brands[$brandName]['models'][] = [
                        'model' => $row['model'] ?: null,
                        'printer_type' => $row['printer_type'] ?: 'Unknown',
                        'count' => (int)$row['count']
                    ];
                }
                $response['printers']['brands'] = array_values($brands);
            } catch (PDOException $e) {
                error_log("Printer brands query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (printer brands): ' . $e->getMessage()];
            }

            // Network Equipment
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) IN ('Network Equipment')";
            try {
                error_log("Executing network equipment total query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
                error_log("Network equipment total result: $total");
                $response['network_equipment']['total'] = $total;
            } catch (PDOException $e) {
                error_log("Network equipment total query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (network equipment total): ' . $e->getMessage()];
            }

            // Network Equipment Categories
            $query = "SELECT h.item_desc as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) IN ('Network Equipment')
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            try {
                error_log("Executing network equipment categories query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Network equipment categories result: " . json_encode($rows));
                $categories = [];
                foreach ($rows as $row) {
                    $categoryName = $row['category'] ?: 'Unknown';
                    if (!isset($categories[$categoryName])) {
                        $categories[$categoryName] = [
                            'name' => $categoryName,
                            'items' => []
                        ];
                    }
                    $categories[$categoryName]['items'][] = [
                        'brand' => $row['brand'] ?: 'Unknown',
                        'model' => $row['model'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
                $response['network_equipment']['categories'] = array_values($categories);
            } catch (PDOException $e) {
                error_log("Network equipment categories query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (network equipment categories): ' . $e->getMessage()];
            }

            // UPS
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%UPS%'";
            try {
                error_log("Executing ups total query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
                error_log("UPS total result: $total");
                $response['ups']['total'] = $total;
            } catch (PDOException $e) {
                error_log("UPS total query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (ups total): ' . $e->getMessage()];
            }

            // UPS Categories
            $query = "SELECT h.item_desc as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%UPS%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            try {
                error_log("Executing UPS categories query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("UPS categories result: " . json_encode($rows));
                $categories = [];
                foreach ($rows as $row) {
                    $categoryName = $row['category'] ?: 'Unknown';
                    if (!isset($categories[$categoryName])) {
                        $categories[$categoryName] = [
                            'name' => $categoryName,
                            'items' => []
                        ];
                    }
                    $categories[$categoryName]['items'][] = [
                        'brand' => $row['brand'] ?: 'Unknown',
                        'model' => $row['model'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
                $response['ups']['categories'] = array_values($categories);
            } catch (PDOException $e) {
                error_log("UPS categories query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (network equipment categories): ' . $e->getMessage()];
            }

            // Peripherals
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%Peripherals%'";
            try {
                error_log("Executing peripheral total query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
                error_log("Peripheral total result: $total");
                $response['peripherals']['total'] = $total;
            } catch (PDOException $e) {
                error_log("Peripheral total query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (peripherals total): ' . $e->getMessage()];
            }



            // Peripheral Webcam Brands
            $query = "SELECT item_desc as model, COUNT(*) as count 
                      FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'Peripherals' 
                      GROUP BY h.item_desc 
                      ORDER BY count DESC";
            try {
                error_log("Executing webcam brands query: $query with params: " . json_encode($whereParams));
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Webcam brands result: " . json_encode($rows));
                $brands = [];
                foreach ($rows as $row) {
                    $brandName = $row['brand'] ?: 'Unknown';
                    if (!isset($brands[$brandName])) {
                        $brands[$brandName] = [
                            'brand' => $brandName,
                            'models' => []
                        ];
                    }
                    $brands[$brandName]['models'][] = [
                        'model' => $row['model'] ?: null,
                        'count' => (int)$row['count']
                    ];
                }
                $response['peripherals']['webcam_brands'] = array_values($brands);
            } catch (PDOException $e) {
                error_log("Webcam brands query error: " . $e->getMessage());
                $this->closeConn();
                return ['error' => 'Database query failed (webcam brands): ' . $e->getMessage()];
            }

            $this->closeConn();
            error_log("Returning hardware data: " . json_encode($response, JSON_PRETTY_PRINT));
            return $response;
        } catch (PDOException $e) {
            error_log("Database connection error in HardwareDAO: " . $e->getMessage());
            $this->closeConn();
            return ['error' => 'Database connection failed: ' . $e->getMessage()];
        }
    }
}