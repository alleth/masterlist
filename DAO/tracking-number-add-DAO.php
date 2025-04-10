<?php
include "BaseDAO.php";
class trackingNumAddDAO extends BaseDAO {
    function trackingNumAdd($tracking_num, $hw_id_pullout, $datePullout, $user_id){

        $this->openConn();

        $get_hw_details = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $get_hw_details->bindParam(1, $hw_id_pullout);
        $get_hw_details->execute();

        while($site_code_row = $get_hw_details->fetch()){
            $siteCode = $site_code_row[2];
        }

        $pullout_status = "In-transit";

        $stmt = $this->dbh->prepare("INSERT INTO tracking_tbl (trxn_date, tracking_num, site_code, hw_id, user_id, pullout_date, pullout_status) VALUES (NOW(), ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $tracking_num);
        $stmt->bindParam(2, $siteCode);
        $stmt->bindParam(3, $hw_id_pullout);
        $stmt->bindParam(4, $user_id);
        $stmt->bindParam(5, $datePullout);
        $stmt->bindParam(6, $pullout_status);
        $stmt->execute();

        echo "Success";

        $this->closeConn();
    }
}