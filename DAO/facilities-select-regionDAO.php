<?php
require_once("BaseDAO.php");

class RegionDAO extends BaseDAO {

    public function getAllRegions() {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT region_id, region_name FROM region_tbl ORDER BY region_id ASC");
        $stmt->execute();
        $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $regions;
    }

}
