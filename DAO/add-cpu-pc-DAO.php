<?php
include "BaseDAO.php";
class addCPUDataDAO extends BaseDAO {
    function addCPUData($region_name, $site_name, $site_code, $brand_name, $model_name, $asset_num, $serial_num, $hw_month, $hw_day, $hw_year, $status_option, $host_name, $ip_address, $mac_address, $user_name, $primary_role, $acquired_value) {

        $this->openConn();
        $stmt2 = $this->dbh->prepare("SELECT * FROM hw_tbl");
        $stmt2->execute();
        $this->closeConn();

        $chckAssetNum = "";
        $chckSerialNum = "";
        while ($row = $stmt2->fetch()) {
            $chckAssetNum = $row[6];
            $chckSerialNum = $row[7];
        }
        $this->openConn();
        $region_details = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id =?");
        $region_details->bindParam(1, $region_name);
        $region_details->execute();
        $this->closeConn();
        while ($row2 = $region_details->fetch()) {
            $chckRegionName = $row2[1];
        }
        $this->openConn();
        $site_details = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_id =?");
        $site_details->bindParam(1, $site_name);
        $site_details->execute();
        $this->closeConn();
        while ($row3 = $site_details->fetch()) {
            $chckSiteName = $row3[2];
        }
        if($asset_num == $chckAssetNum){
            echo "asset number";
        }else if($serial_num == $chckSerialNum){
            echo "serial number";
        }else{
            $this->openConn();
            $stmt = $this->dbh->prepare("INSERT INTO hw_tbl (region_name, site_code, site_name, hw_brand_name, hw_model, hw_asset_num, hw_serial_num, hw_month_acq, hw_day_acq, hw_year_acq, hw_status, hw_host_name, hw_ip_add, hw_mac_add, hw_user_name,hw_primary_role, hw_acq_val) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bindParam(1, $chckRegionName);
            $stmt->bindParam(2, $site_code);
            $stmt->bindParam(3, $chckSiteName);
            $stmt->bindParam(4, $brand_name);
            $stmt->bindParam(5, $model_name);
            $stmt->bindParam(6, $asset_num);
            $stmt->bindParam(7, $serial_num);
            $stmt->bindParam(8, $hw_month);
            $stmt->bindParam(9, $hw_day);
            $stmt->bindParam(10, $hw_year);
            $stmt->bindParam(11, $status_option);
            $stmt->bindParam(12, $host_name);
            $stmt->bindParam(13, $ip_address);
            $stmt->bindParam(14, $mac_address);
            $stmt->bindParam(15, $user_name);
            $stmt->bindParam(16, $primary_role);
            $stmt->bindParam(17, $acquired_value);
            $stmt->execute();
            $this->closeConn();
            echo "success";
        }
    }
}