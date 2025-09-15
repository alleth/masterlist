<?php
require_once 'BaseDAO.php';

class DashboardDAO extends BaseDAO {
    private $conn;

    public function __construct() {
        $this->openConn();
        $this->conn = $this->dbh;
    }

    public function __destruct() {
        $this->closeConn();
    }

    public function getDashboardCounts($region = '', $site = '') {
        $sql = "
            SELECT 
                SUM(CASE WHEN item_desc = 'CPU-Server' THEN 1 ELSE 0 END) AS server_count,
                SUM(CASE WHEN item_desc = 'CPU-Server' THEN 1 ELSE 0 END) AS server2_count,

                SUM(CASE WHEN item_desc = 'CPU-Server' AND hw_brand_name LIKE '%HP%' THEN 1 ELSE 0 END) AS server_hp_count,
                SUM(CASE WHEN item_desc = 'CPU-Server' AND hw_brand_name LIKE '%IBM%' THEN 1 ELSE 0 END) AS server_ibm_count,
                SUM(CASE WHEN item_desc = 'CPU-Server' AND hw_brand_name LIKE '%Xitrix%' THEN 1 ELSE 0 END) AS server_xitrix_count,
                SUM(CASE WHEN item_desc = 'CPU-Server' AND hw_brand_name LIKE '%DELL%' THEN 1 ELSE 0 END) AS server_dell_count,
                SUM(CASE WHEN item_desc = 'CPU-Server' AND hw_brand_name LIKE '%Lenovo%' THEN 1 ELSE 0 END) AS server_lenovo_count,

                SUM(CASE WHEN item_desc = 'CPU-PC' THEN 1 ELSE 0 END) AS cpu_pc_count,
                SUM(CASE WHEN os_type LIKE '%XP%' THEN 1 ELSE 0 END) AS xp_count,
                SUM(CASE WHEN os_type LIKE '%10 32%' THEN 1 ELSE 0 END) AS w1032bit_count,
                SUM(CASE WHEN os_type LIKE '%10 64%' THEN 1 ELSE 0 END) AS w1064bit_count,
                SUM(CASE WHEN os_type LIKE '%11%' THEN 1 ELSE 0 END) AS w11_count,

                SUM(CASE WHEN item_desc LIKE 'Monitor%' THEN 1 ELSE 0 END) AS monitor_count,
                SUM(CASE WHEN item_desc LIKE 'keyboard' THEN 1 ELSE 0 END) AS keybpard_count,
                SUM(CASE WHEN item_desc LIKE 'mouse' THEN 1 ELSE 0 END) AS mouse_count,

                SUM(CASE WHEN item_desc LIKE 'webcam' THEN 1 ELSE 0 END) AS webcam_count,
                SUM(CASE WHEN item_desc LIKE 'sigpad' THEN 1 ELSE 0 END) AS sigpad_count,
                SUM(CASE WHEN item_desc LIKE '%POS%' THEN 1 ELSE 0 END) AS pos_count,
                SUM(CASE WHEN item_desc LIKE 'LCD Display' THEN 1 ELSE 0 END) AS LCD_Display_count,
                SUM(CASE WHEN item_desc LIKE 'Cash Drawer' THEN 1 ELSE 0 END) AS cash_drawer_count,

                SUM(CASE WHEN rsu_fac = '1' OR hw_utilities LIKE '%RSU Facility%' THEN 1 ELSE 0 END) AS rsu_count,
                SUM(CASE WHEN mv_dto = '1' OR hw_utilities LIKE '%MV DTO%' THEN 1 ELSE 0 END) AS mvdto_count,
                SUM(CASE WHEN mv_maint = '1' OR hw_utilities LIKE '%MV Maintenance%' THEN 1 ELSE 0 END) AS mvmaint_count,
                SUM(CASE WHEN ims_aiu = '1' OR hw_utilities LIKE '%IMS-AIU%' THEN 1 ELSE 0 END) AS imsaiu_count,
                SUM(CASE WHEN dl_dto = '1' OR hw_utilities LIKE '%DL DTO%' THEN 1 ELSE 0 END) AS dldto_count,
                SUM(CASE WHEN dl_maint = '1' OR hw_utilities LIKE '%DL Manint%' THEN 1 ELSE 0 END) AS dlmaint_count,
                
                SUM(CASE WHEN item_desc LIKE '%switch%' THEN 1 ELSE 0 END) AS switch_count,
                SUM(CASE WHEN item_desc LIKE '%sdwan%' THEN 1 ELSE 0 END) AS sdwan_count,
                SUM(CASE WHEN item_desc LIKE '%router%' THEN 1 ELSE 0 END) AS router_count,

                SUM(CASE WHEN item_desc LIKE '%LaserJet%' THEN 1 ELSE 0 END) AS laserjet_count,
                SUM(CASE WHEN item_desc LIKE '%dot%' THEN 1 ELSE 0 END) AS dotmatrix_count,
                SUM(CASE WHEN item_desc LIKE '%inkjet%' THEN 1 ELSE 0 END) AS inkjet_count,
                SUM(CASE WHEN item_desc LIKE '%deskjet%' THEN 1 ELSE 0 END) AS deskjet_count,

                SUM(CASE WHEN item_desc LIKE 'laserjet' AND hw_model LIKE '%4100%' THEN 1 ELSE 0 END) AS l4100_count,
                SUM(CASE WHEN item_desc LIKE 'laserjet' AND hw_model LIKE '%507%' THEN 1 ELSE 0 END) AS l507_count,
                SUM(CASE WHEN (item_desc LIKE '%dot matrix%' OR item_desc LIKE '%dotmatrix%') AND (hw_model LIKE '%lx300%' OR hw_model LIKE '%lx-300%')THEN 1 ELSE 0 END) AS lx300_count,
                SUM(CASE WHEN (item_desc LIKE '%inkjet%' OR item_desc LIKE '%ink jet%') AND (hw_model LIKE '%l310%')THEN 1 ELSE 0 END) AS l310_count,
                SUM(CASE WHEN item_desc LIKE 'laserjet' AND hw_model LIKE '%4250%' THEN 1 ELSE 0 END) AS l4250_count,
                SUM(CASE WHEN item_desc LIKE 'laserjet' AND hw_model LIKE '%2015%' THEN 1 ELSE 0 END) AS l2015_count,
                SUM(CASE WHEN (item_desc LIKE '%dot matrix%' OR item_desc LIKE '%dotmatrix%') AND (hw_model LIKE '%lx310%' OR hw_model LIKE '%lx-310%')THEN 1 ELSE 0 END) AS lx310_count,
                SUM(CASE WHEN item_desc LIKE '%inkjet%' AND hw_model LIKE '%l360%' THEN 1 ELSE 0 END) AS l360_count,
                SUM(CASE WHEN item_desc LIKE 'laserjet' AND hw_model LIKE '%401%' THEN 1 ELSE 0 END) AS m401_count,
                SUM(CASE WHEN item_desc LIKE 'laserjet' AND hw_model LIKE '%402%' THEN 1 ELSE 0 END) AS m402_count,
                SUM(CASE WHEN item_desc LIKE '%laserjet%' AND hw_model LIKE '%4003dn%' THEN 1 ELSE 0 END) AS l4003_count,
                SUM(CASE WHEN item_desc LIKE '%deskjet%' AND hw_model LIKE '%1280%' THEN 1 ELSE 0 END) AS hp1280_count,
                SUM(
                    CASE 
                        WHEN item_desc LIKE 'LASERJET' 
                            AND hw_model NOT LIKE '%4100%'
                            AND hw_model NOT LIKE '%507%'
                            AND hw_model NOT LIKE '%l310%'
                            AND hw_model NOT LIKE '%4250%'
                            AND hw_model NOT LIKE '%2015%'
                            AND hw_model NOT LIKE '%lc310%'
                            AND hw_model NOT LIKE '%l360%'
                            AND hw_model NOT LIKE '%401%'
                            AND hw_model NOT LIKE '%402%'
                            AND hw_model NOT LIKE '%4003%'
                        THEN 1 
                        ELSE 0 
                    END
                ) AS other_printer_count,

                COUNT(*) AS total_count
            FROM hw_tbl
            WHERE hw_status = 'On Site'
        ";

        $params = [];

        if (!empty($region)) {
            $sql .= " AND region_name = :region";
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
