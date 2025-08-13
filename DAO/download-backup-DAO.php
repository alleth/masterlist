<?php
require_once 'BaseDAO.php';

class BackupDownloadDAO extends BaseDAO {

    public function getAllHardwareBackup() {
        $this->openConn();
        $sql = "SELECT hw_id, region_name, site_code, major_type, sub_major_type,
                       item_desc, hw_brand_name, hw_model, hw_asset_num, hw_serial_num,
                       hw_date_acq, hw_acq_val, hw_status, hw_host_name, hw_ip_add,
                       hw_mac_add, hw_user_name, hw_primary_role, hw_memory, hdd_capacity,
                       hdd_free_space, hdd_health, os_type, core_buid, rsu_fac, mv_dto,
                       mv_maint, ims_aiu, dl_dto, dl_maint, dotnet, hw_antivi, ports_num,
                       ports_working, ports_deffect, user_id
                FROM hw_tbl";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $rows;
    }
}
