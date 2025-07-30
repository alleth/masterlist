<?php
require_once 'BaseDAO.php';

class HardwareExportDAO extends BaseDAO {

    public function fetchHardwareBySite($site_code) {
        $this->openConn();

        $stmt = $this->dbh->prepare("
            SELECT 
                region_name,
                site_code, 
                item_desc, 
                hw_brand_name, 
                hw_model, 
                hw_asset_num, 
                hw_serial_num 
            FROM hw_tbl 
            WHERE site_code = ?
        ");
        $stmt->execute([$site_code]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->closeConn();
        return $results;
    }
}
