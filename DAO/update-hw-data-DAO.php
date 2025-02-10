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

        $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
        $site_name->bindParam(1, $record[2]);
        $site_name->execute();

        while($site_row = $site_name->fetch()){
            $get_siteName = $site_row[2];
        }

        $count = array("hw_id"=>$record[0], "region_name"=>$getRegion, "site_code"=>$record[2], "site_name"=>$get_siteName, "hw_brand_name"=>$record[6], "hw_model"=>$record[7], "hw_asset_num"=>$record[8], "hw_serial_num"=>$record[9], "hw_date_acq"=>$record[10], "hw_status"=>$record[12], "hw_acq_val"=>$record[11], "hw_host_name"=>$record[13], "hw_ip_add"=>$record[14], "hw_mac_add"=>$record[15], "hw_user_assigned"=>$record[16], "hw_role"=>$record[17],"hw_user_name"=>$record[18]);
        $json_string = json_encode($count);
        echo $json_string;
        $this->closeConn();
    }
}