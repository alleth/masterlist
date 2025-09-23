<?php
require_once 'BaseDAO.php';

class HardwareDAO extends BaseDAO
{
    public function getRegions()
    {
        try {
            $this->openConn();
            $conn = $this->dbh;
            $query = "SELECT region_id, region_name FROM region_tbl ORDER BY region_id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeConn();
            error_log("getRegions: Found " . count($regions) . " regions");
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
            $query = "SELECT DISTINCT s.site_code, s.site_name 
                      FROM site_list_tbl s
                      JOIN hw_tbl h ON s.site_code = h.site_code
                      WHERE CAST(s.region_id AS SIGNED) = ? 
                      ORDER BY s.site_code";
            $stmt = $conn->prepare($query);
            $stmt->execute([$region_id]);
            $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeConn();
            error_log("getSites: Found " . count($sites) . " sites for region_id=$region_id");
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
            }

            // Site filter
            if (!empty($params['site_code']) && $params['site_code'] !== '0') {
                $query = "SELECT office_type, site_partnership, trxn_catered
                          FROM site_list_tbl 
                          WHERE site_code = ? AND region_id = ?";
                $whereParams = [$params['site_code'], $params['region_id']];
                $stmt = $conn->prepare($query);
                $stmt->execute($whereParams);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->closeConn();
                return [
                    'office_type' => $result['office_type'] ?: 'Unknown',
                    'site_partnership' => $result['site_partnership'] ?: 'Unknown',
                    'trxn_catered' => $result['trxn_catered'] ?: 'Unknown'
                ];
            }

            // Total unique site_name + office_type combinations
            $query = "SELECT COUNT(DISTINCT CONCAT(
                        TRIM(REGEXP_REPLACE(site_name, '\\\\s+', ' ')),
                        '|',
                        office_type
                    )) as total_sites
                    FROM site_list_tbl $where";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $totalSites = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total_sites'];
            $response['total_sites'] = $totalSites;

            // Proponent count
            $query = "SELECT COUNT(DISTINCT site_code) as count 
                      FROM site_list_tbl $where AND site_partnership = 'Proponent'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $proponentCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
            $response['proponent_count'] = $proponentCount;

            // Government count
            $query = "SELECT COUNT(DISTINCT site_code) as count 
                      FROM site_list_tbl $where AND site_partnership = 'Government'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $governmentCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
            $response['government_count'] = $governmentCount;

            $this->closeConn();
            error_log("getSiteCounts: total_sites=$totalSites, proponent=$proponentCount, government=$governmentCount");
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
                'servers' => ['total' => 0, 'brands' => [], 'os' => [], 'server_type' => []],
                'workstations' => ['total' => 0, 'brands' => [], 'os' => []],
                'monitors' => ['total' => 0, 'monitor_types' => []],
                'printers' => ['total' => 0, 'printer_types' => []],
                'peripherals' => [
                    'total' => 0,
                    'categories' => [],
                    'webcam_brands' => [],
                    'sigpad_brands' => []
                ],
                'network_equipment' => [
                    'total' => 0,
                    'categories' => []
                ],
                'ups' => [
                    'total' => 0,
                    'categories' => []
                ],
                'other_equipment' => [
                    'total' => 0,
                    'categories' => []
                ]
            ];

            // Base WHERE clause
            $where = "WHERE h.hw_status = 'On Site'";
            $whereParams = [];

            // Region filter
            if (!empty($params['region_id'])) {
                $where .= " AND s.region_id = ?";
                $whereParams[] = $params['region_id'];
            }

            // Site filter
            if (!empty($params['site_code']) && $params['site_code'] !== '0') {
                $where .= " AND h.site_code = ?";
                $whereParams[] = $params['site_code'];
            }

            // Join with site_list_tbl for region filter
            $join = !empty($params['region_id']) ? "JOIN site_list_tbl s ON h.site_code = s.site_code" : "";

            // Total count
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $join $where";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['total'] = $total;

            // Servers
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'server%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['servers']['total'] = $total;

            // Server Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'server%' 
                      GROUP BY h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    'model' => $row['model'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }
            $response['servers']['brands'] = array_values($brands);

            // Server OS
            $query = "SELECT h.os_type as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'server%' 
                      GROUP BY h.os_type 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $response['servers']['os'][] = [
                    'name' => $row['name'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }

            // Server Type
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'server%' 
                      GROUP BY h.item_desc 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $response['servers']['server_type'][] = [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }
            // Ensure total is included if no server types
            if (empty($response['servers']['server_type']) && $response['servers']['total'] > 0) {
                $response['servers']['server_type'][] = [
                    'name' => 'Total Servers',
                    'count' => $response['servers']['total']
                ];
            }

            // Workstations
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'cpu%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['workstations']['total'] = $total;

            // Workstation Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'cpu%' 
                      GROUP BY h.hw_brand_name, h.hw_model 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    'model' => $row['model'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }
            $response['workstations']['brands'] = array_values($brands);

            // Workstation OS
            $query = "SELECT h.os_type as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE 'cpu%' 
                      GROUP BY h.os_type 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $response['workstations']['os'][] = [
                    'name' => $row['name'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }

            // Monitors
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE '%monitor%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['monitors']['total'] = $total;

            // Monitor Types
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE '%monitor%' 
                      GROUP BY h.item_desc 
                      HAVING count > 0 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['monitors']['monitor_types'] = array_map(function($row) {
                return [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }, $rows);

            // Printers
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE '%printer%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['printers']['total'] = $total;

            // Printer Types
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where AND LOWER(h.sub_major_type) LIKE '%printer%' 
                      GROUP BY h.item_desc 
                      HAVING count > 0 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['printers']['printer_types'] = array_map(function($row) {
                return [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }, $rows);

            // Network Equipment
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE 'network equipment%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['network_equipment']['total'] = $total;

            // Network Equipment Categories
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE 'network equipment%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [];
            foreach ($rows as $row) {
                $categoryName = $row['category'];
                if (!isset($categories[$categoryName])) {
                    $categories[$categoryName] = [
                        'name' => $categoryName,
                        'items' => []
                    ];
                }
                $categories[$categoryName]['items'][] = [
                    'brand' => $row['brand'] ?: 'Unknown',
                    'model' => $row['model'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }
            $response['network_equipment']['categories'] = array_values($categories);

            // UPS
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE '%ups%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['ups']['total'] = $total;

            // UPS Categories
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE '%ups%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [];
            foreach ($rows as $row) {
                $categoryName = $row['category'];
                if (!isset($categories[$categoryName])) {
                    $categories[$categoryName] = [
                        'name' => $categoryName,
                        'items' => []
                    ];
                }
                $categories[$categoryName]['items'][] = [
                    'brand' => $row['brand'] ?: 'Unknown',
                    'model' => $row['model'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }
            $response['ups']['categories'] = array_values($categories);

            // Peripherals
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE '%peripheral%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['peripherals']['total'] = $total;

            // Peripheral Categories
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE '%peripheral%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [];
            foreach ($rows as $row) {
                $categoryName = $row['category'];
                if (!isset($categories[$categoryName])) {
                    $categories[$categoryName] = [
                        'name' => $categoryName,
                        'items' => []
                    ];
                }
                $categories[$categoryName]['items'][] = [
                    'brand' => $row['brand'] ?: 'Unknown',
                    'model' => $row['model'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }
            $response['peripherals']['categories'] = array_values($categories);

            // Peripheral Webcam Brands
            $query = "SELECT IFNULL(h.hw_brand_name, 'Unspecified') as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.item_desc) LIKE '%webcam%' 
                      GROUP BY h.hw_brand_name 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['peripherals']['webcam_brands'] = array_map(function($row) {
                return [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }, $rows);

            // Peripheral Sigpad Brands
            $query = "SELECT IFNULL(h.hw_brand_name, 'Unspecified') as name, COUNT(*) as count 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.item_desc) LIKE '%sigpad%' 
                      GROUP BY h.hw_brand_name 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['peripherals']['sigpad_brands'] = array_map(function($row) {
                return [
                    'name' => $row['name'],
                    'count' => (int)$row['count']
                ];
            }, $rows);

            // Other Equipment
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE '%other equipment%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['other_equipment']['total'] = $total;

            // Other Equipment Categories
            $query = "SELECT IFNULL(h.item_desc, 'Unspecified') as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $join $where 
                      AND LOWER(h.sub_major_type) LIKE '%other equipment%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [];
            foreach ($rows as $row) {
                $categoryName = $row['category'];
                if (!isset($categories[$categoryName])) {
                    $categories[$categoryName] = [
                        'name' => $categoryName,
                        'items' => []
                    ];
                }
                $categories[$categoryName]['items'][] = [
                    'brand' => $row['brand'] ?: 'Unknown',
                    'model' => $row['model'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }
            $response['other_equipment']['categories'] = array_values($categories);

            $this->closeConn();
            error_log("getHardwareCounts: total=$total, servers={$response['servers']['total']}, workstations={$response['workstations']['total']}");
            return $response;
        } catch (PDOException $e) {
            error_log("getHardwareCounts error: " . $e->getMessage());
            $this->closeConn();
            return ['error' => 'Database query failed: ' . $e->getMessage()];
        }
    }
}
?>