<?php

require_once "BaseDAO.php";

class SiteCountDAO extends BaseDAO {
    private $conn;

    public function __construct() {
        $this->openConn();
        $this->conn = $this->dbh;
    }

    public function __destruct() {
        $this->closeConn();
    }

    public function getSiteCount($region = '', $site = '') {
        $sql = "
            SELECT 
                CAST(SUM(CASE WHEN physical_site_count > 0 THEN 1.0 / physical_site_count ELSE 0 END) AS UNSIGNED) AS actualSite_total,
                CAST(SUM(CASE WHEN physical_site_count = 2 THEN 1.0 / 2 ELSE 0 END) AS UNSIGNED) AS dualServer_total,
                SUM(CASE WHEN site_partnership IS NOT NULL AND site_partnership NOT LIKE '%proponent%' THEN 1 ELSE 0 END) AS government_total, 
                
                SUM(CASE WHEN site_partnership LIKE '%proponent%' THEN 1 ELSE 0 END) AS proponent_count,

                SUM(CASE WHEN office_type LIKE '%Regional Office%' THEN 1 ELSE 0 END) AS ro_count,
                SUM(CASE WHEN office_type LIKE '%NRU%' THEN 1 ELSE 0 END) AS nru_count,
                SUM(CASE WHEN office_type LIKE '%Licensing Center%' THEN 1 ELSE 0 END) AS lc_count,
                SUM(CASE WHEN office_type LIKE '%MAIDRS%' THEN 1 ELSE 0 END) AS maidrs_count,
                SUM(CASE WHEN office_type LIKE '%District Office%' THEN 1 ELSE 0 END) AS do_count,
                SUM(CASE WHEN office_type LIKE '%DLRO%' THEN 1 ELSE 0 END) AS dlro_count,
                SUM(CASE WHEN office_type LIKE '%Extension Office%' THEN 1 ELSE 0 END) AS eo_count,
                SUM(CASE WHEN office_type LIKE '%E-Patrol%' THEN 1 ELSE 0 END) AS epat_count,
                SUM(CASE WHEN office_type LIKE '%Operations Division%' THEN 1 ELSE 0 END) AS opd_count,

                SUM(CASE WHEN trxn_catered LIKE '%MV%' THEN 1 ELSE 0 END) AS mv_count,
                SUM(CASE WHEN trxn_catered LIKE '%NRU%' THEN 1 ELSE 0 END) AS mvnew_count,
                SUM(CASE WHEN trxn_catered LIKE '%DL%' THEN 1 ELSE 0 END) AS dl_count,
                SUM(CASE WHEN trxn_catered LIKE '%DLNEW%' THEN 1 ELSE 0 END) AS dlnew_count,
                SUM(CASE WHEN trxn_catered LIKE '%LETAS%' THEN 1 ELSE 0 END) AS letas_count,
                SUM(CASE WHEN trxn_catered LIKE '%MAIDRS%' THEN 1 ELSE 0 END) AS maidrstx_count,

                SUM(CASE WHEN trxn_catered LIKE '%MV%' THEN 1 ELSE 0 END) AS mvtx_count,
                SUM(CASE WHEN trxn_catered LIKE '%NRU%' THEN 1 ELSE 0 END) AS mvnewtx_count,
                SUM(CASE WHEN trxn_catered LIKE '%DL%' THEN 1 ELSE 0 END) AS dltx_count,
                SUM(CASE WHEN trxn_catered LIKE '%DLNEW%' THEN 1 ELSE 0 END) AS dlnewtx_count,
                SUM(CASE WHEN trxn_catered LIKE '%LETAS%' THEN 1 ELSE 0 END) AS letastx_count,
                SUM(CASE WHEN trxn_catered LIKE '%MAIDRS%' THEN 1 ELSE 0 END) AS maidrstxtx_count,

                COUNT(*) AS site_total
            FROM site_list_tbl
            WHERE 1=1
        ";

        $params = [];
        if (!empty($region)) {
            $sql .= " AND region_id = :region";
            $params[':region'] = $region;
        }
        if (!empty($site)) {
            $sql .= " AND site_code = :site";
            $params[':site'] = $site;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/*
require_once "BaseDAO.php";

class SiteCountDAO {
    private $conn;

    public function __construct() {
        $db = new BaseDAO();
        $db->openConn();
        $this->conn = $db->getConnection();
    }

    public function getSiteCount($region = '', $site = '') {
    $sql = "
        SELECT 
            CAST(SUM(CASE WHEN physical_site_count > 0 THEN 1.0 / physical_site_count ELSE 0 END) AS UNSIGNED) AS actualSite_total,
            CAST(SUM(CASE WHEN physical_site_count = 2 THEN 1.0 / 2 ELSE 0 END) AS UNSIGNED) AS dualServer_total,
            SUM(CASE WHEN site_partnership IS NOT NULL AND site_partnership NOT LIKE '%proponent%' THEN 1 ELSE 0 END) AS government_total, 
            SUM(CASE WHEN site_partnership LIKE '%proponent%' THEN 1 ELSE 0 END) AS proponent_count,

            SUM(CASE WHEN office_type LIKE '%Regional Office%' THEN 1 ELSE 0 END) AS ro_count,
            SUM(CASE WHEN office_type LIKE '%NRU%' THEN 1 ELSE 0 END) AS nru_count,
            SUM(CASE WHEN office_type LIKE '%Licensing Center%' THEN 1 ELSE 0 END) AS lc_count,
            SUM(CASE WHEN office_type LIKE '%MAIDRS%' THEN 1 ELSE 0 END) AS maidrs_count,
            SUM(CASE WHEN office_type LIKE '%District Office%' THEN 1 ELSE 0 END) AS do_count,
            SUM(CASE WHEN office_type LIKE '%DLRO%' THEN 1 ELSE 0 END) AS dlro_count,
            SUM(CASE WHEN office_type LIKE '%Extension Office%' THEN 1 ELSE 0 END) AS eo_count,
            SUM(CASE WHEN office_type LIKE '%E-Patrol%' THEN 1 ELSE 0 END) AS epat_count,
            SUM(CASE WHEN office_type LIKE '%Operations Division%' THEN 1 ELSE 0 END) AS opd_count,

            SUM(CASE WHEN trxn_catered LIKE '%MV%' THEN 1 ELSE 0 END) AS mv_count,
            SUM(CASE WHEN trxn_catered LIKE '%NRU%' THEN 1 ELSE 0 END) AS mvnew_count,
            SUM(CASE WHEN trxn_catered LIKE '%DL%' THEN 1 ELSE 0 END) AS dl_count,
            SUM(CASE WHEN trxn_catered LIKE '%DLNEW%' THEN 1 ELSE 0 END) AS dlnew_count,
            SUM(CASE WHEN trxn_catered LIKE '%LETAS%' THEN 1 ELSE 0 END) AS letas_count,
            SUM(CASE WHEN trxn_catered LIKE '%MAIDRS%' THEN 1 ELSE 0 END) AS maidrstx_count,


            COUNT(*) AS site_total
        FROM site_list_tbl
        WHERE 1=1
    ";

    $params = [];
    if (!empty($region)) {$sql .= " AND region_id = :region"; $params[':region'] = $region;}
    if (!empty($site))   {$sql .= " AND site_code = :site";   $params[':site'] = $site;}

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
*/