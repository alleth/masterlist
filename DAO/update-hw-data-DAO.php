<?php
include "BaseDAO.php";
class updateHWDataDAO extends BaseDAO {
    function updateHWData($hwValue){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $stmt->bindParam(1,$hwValue);
        $stmt->execute();

        $record = $stmt->fetch();

        $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
        $region_name->bindParam(1, $record[1]);
        $region_name->execute();

        while ($region_row = $region_name->fetch()){
            $getRegion = $region_row[1];
        }

        $count = array("hw_id"=>$record[0], "region_name"=>$getRegion, "site_code"=>$record[2], "site_name"=>$record[3], "hw_brand_name"=>$record[5], "hw_model"=>$record[6], "hw_asset_num"=>$record[7], "hw_serial_num"=>$record[8], "hw_month_acq"=>$record[9], "hw_day_acq"=>$record[10], "hw_year_acq"=>$record[11], "hw_status"=>$record[12], "hw_host_name"=>$record[13], "hw_ip_add"=>$record[14], "hw_mac_add"=>$record[15], "hw_user_name"=>$record[16], "hw_primary_role"=>$record[17], "hw_acq_val"=>$record[18]);
        $json_string = json_encode($count);
        echo $json_string;
        $this->closeConn();
    }
}