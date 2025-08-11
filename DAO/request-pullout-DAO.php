<?php
include "BaseDAO.php";

class requestPulloutDAO extends BaseDAO {
    function viewSite($region_assigned) {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT site_id, site_code, site_name FROM site_list_tbl WHERE region_id = ?");
        $stmt->bindParam(1, $region_assigned);
        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($records);
    }

    function viewHardware($hw_type, $site_code) {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT hw_id, hw_asset_num, hw_serial_num, hw_brand_name, hw_model FROM hw_tbl WHERE item_desc = ? AND site_code = ?");
        $stmt->bindParam(1, $hw_type);
        $stmt->bindParam(2, $site_code);
        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($records);
    }
}
