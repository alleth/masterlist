<?php

require_once 'BaseDAO.php';

class HardwareExportDAO extends BaseDAO {

    public function fetchHardwareBySite($site_code) {
        $this->openConn();

        $stmt = $this->dbh->prepare("
            SELECT 
                r.region_name,
                h.site_code,
                s.site_name,
                h.item_desc,
                h.hw_brand_name,
                h.hw_model,
                h.hw_asset_num,
                h.hw_serial_num
            FROM hw_tbl h
            LEFT JOIN region_tbl r ON h.region_name = r.region_id
            LEFT JOIN site_list_tbl s ON h.site_code = s.site_code
            WHERE h.site_code = ? AND h.hw_status = 'On Site'
        ");
        $stmt->execute([$site_code]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->closeConn();
        return $results;
    }

    public function fetchHardwareByRegion($region_name) {
        $this->openConn();

        if ($region_name === 'All Region') {
            $stmt = $this->dbh->prepare("
                SELECT 
                    r.region_name,
                    h.site_code,
                    s.site_name,
                    h.item_desc,
                    h.hw_brand_name,
                    h.hw_model,
                    h.hw_asset_num,
                    h.hw_serial_num
                FROM hw_tbl h
                LEFT JOIN region_tbl r ON h.region_name = r.region_id
                LEFT JOIN site_list_tbl s ON h.site_code = s.site_code
                WHERE h.hw_status = 'On Site'
            ");
            $stmt->execute();
        } else {
            $stmt = $this->dbh->prepare("
                SELECT 
                    r.region_name,
                    h.site_code,
                    s.site_name,
                    h.item_desc,
                    h.hw_brand_name,
                    h.hw_model,
                    h.hw_asset_num,
                    h.hw_serial_num
                FROM hw_tbl h
                LEFT JOIN region_tbl r ON h.region_name = r.region_id
                LEFT JOIN site_list_tbl s ON h.site_code = s.site_code
                WHERE h.region_name = ? AND h.hw_status = 'On Site'
            ");
            $stmt->execute([$region_name]);
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $results;
    }
}
