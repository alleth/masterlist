<?php
require_once 'DAO/BaseDAO.php';

class FilterHelper extends BaseDAO {
    public function getRegions() {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT region_id, region_name FROM region_tbl ORDER BY region_id");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $rows;
    }

    public function getSites($regionId = '') {
        $this->openConn();
        if (!empty($regionId)) {
            $sql = "SELECT site_code, site_name 
                    FROM site_list_tbl 
                    WHERE region_id = :region_id 
                    ORDER BY site_code";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([':region_id' => $regionId]);
        } else {
            $sql = "SELECT site_code, site_name FROM site_list_tbl ORDER BY site_code";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $rows;
    }
}

$helper = new FilterHelper();

$type = $_GET['type'] ?? '';

if ($type === 'region') {
    $results = $helper->getRegions();
} elseif ($type === 'site') {
    $results = $helper->getSites($_GET['region_id'] ?? '');
} else {
    $results = [];
}

// ✅ Output JSON
header('Content-Type: application/json');
echo json_encode($results);
exit;
