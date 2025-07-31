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
            return $regions;
        } catch (PDOException $e) {
            $this->closeConn();
            return ['error' => 'Database query failed (regions): ' . $e->getMessage()];
        }
    }

    public function getSites($region_id)
    {
        try {
            if (empty($region_id)) {
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
            return $sites;
        } catch (PDOException $e) {
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
            return $response;
        } catch (PDOException $e) {
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
                ],
                'ups' => [
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
            }

            // Site filter
            if (!empty($params['site_code']) && $params['site_code'] !== '0') {
                $where .= " AND h.site_code = ?";
                $whereParams[] = $params['site_code'];
            }

            // Total count
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['total'] = $total;

            // Servers
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where AND (LOWER(h.sub_major_type) LIKE 'server')";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['servers']['total'] = $total;

            // Server Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where AND (LOWER(h.sub_major_type) LIKE 'servers' OR LOWER(h.item_desc) LIKE 'CPU-Server') 
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
                    'model' => $row['model'] ?: null,
                    'count' => (int)$row['count']
                ];
            }
            $response['servers']['brands'] = array_values($brands);

            // Server OS
            $query = "SELECT h.os_type as name, COUNT(*) as count 
                      FROM hw_tbl h $where AND (LOWER(h.sub_major_type) LIKE 'server' OR LOWER(h.item_desc) LIKE 'server') 
                      GROUP BY h.os_type 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $response['servers']['os'][] = [
                    'name' => $row['name'] ?: null,
                    'count' => (int)$row['count']
                ];
            }

            // Workstations
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'CPU'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $response['workstations']['total'] = $total;

            // Workstation Brands
            $query = "SELECT h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'CPU' 
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
                    'model' => $row['model'] ?: null,
                    'count' => (int)$row['count']
                ];
            }
            $response['workstations']['brands'] = array_values($brands);

            // Workstation OS
            $query = "SELECT h.os_type as name, COUNT(*) as count 
                      FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE 'CPU' 
                      GROUP BY h.os_type 
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $response['workstations']['os'][] = [
                    'name' => $row['name'] ?: null,
                    'count' => (int)$row['count']
                ];
            }


            // Printers
            $query = "SELECT COUNT(*) as total FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE '%printer%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
            $response['printers']['total'] = $total;

            // Printer Types
            $query = "SELECT h.item_desc as name, COUNT(*) as count 
          FROM hw_tbl h $where AND LOWER(h.sub_major_type) LIKE '%printer%' 
          GROUP BY h.item_desc 
          HAVING count > 0 
          ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['printers']['printer_types'] = array_map(function($row) {
                return [
                    'name' => $row['name'] ?: 'Unknown',
                    'count' => (int)$row['count']
                ];
            }, $rows);

            // Network Equipment
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) IN ('Network Equipment')";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
            $response['network_equipment']['total'] = $total;

            // Network Equipment Categories
            $query = "SELECT h.item_desc as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) IN ('Network Equipment')
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            // UPS
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%UPS%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
            $response['ups']['total'] = $total;

            // UPS Categories
            $query = "SELECT h.item_desc as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%UPS%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            // Peripherals
            $query = "SELECT COUNT(*) as total 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%Peripherals%'";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $total = (int)$stmt->fetch(PDO::FETCH_COLUMN);
            $response['peripherals']['total'] = $total;

            // Peripheral Categories
            $query = "SELECT h.item_desc as category, h.hw_brand_name as brand, h.hw_model as model, COUNT(*) as count 
                      FROM hw_tbl h $where 
                      AND LOWER(h.sub_major_type) LIKE '%Peripherals%'
                      GROUP BY h.item_desc, h.hw_brand_name, h.hw_model
                      ORDER BY count DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute($whereParams);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $response['peripherals']['categories'] = array_values($categories);

            $this->closeConn();
            return $response;
        } catch (PDOException $e) {
            $this->closeConn();
            return ['error' => 'Database connection failed: ' . $e->getMessage()];
        }
    }
}