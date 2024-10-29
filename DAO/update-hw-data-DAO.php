<?php
include "BaseDAO.php";
class updateHWDataDAO extends BaseDAO {
    function updateHWData($hwValue){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $stmt->bindParam(1,$hwValue);
        $stmt->execute();

        $record = $stmt->fetch();
        $count = array("hw_id"=>$record[0], "region_name"=>$record[1], "site_code"=>$record[2], "site_name"=>$record[3], "hw_brand_name"=>$record[4], "hw_model"=>$record[5], "hw_asset_num"=>$record[6], "hw_serial_num"=>$record[7], "hw_month_acq"=>$record[8], "hw_day_acq"=>$record[9], "hw_year_acq"=>$record[10], "hw_status"=>$record[11], "hw_host_name"=>$record[12], "hw_ip_add"=>$record[13], "hw_mac_add"=>$record[14], "hw_user_name"=>$record[15], "hw_primary_role"=>$record[16], "hw_acq_val"=>$record[17]);
        $json_string = json_encode($count);
        echo $json_string;
        $this->closeConn();
    }
}