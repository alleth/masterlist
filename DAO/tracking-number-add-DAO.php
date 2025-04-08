<?php
include "BaseDAO.php";
class trackingNumAddDAO extends BaseDAO {
    function trackingNumAdd($tracking_num, $hw_id_pullout, $datePullout, $user_id){

        $get_hw_details = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $get_hw_details->bindParam(1, $hw_id_pullout);
        $get_hw_details->execute();

        while($site_code_row = $get_hw_details->fetch()){
            $hw_id = $site_code_row[0];
            $siteCode = $site_code_row[2];
        }

        $stmt = $this->dbh->prepare("INSERT INTO hw_tbl (trxn_date, tracking_num, site_code, hw_id, user_id, pullout_date) VALUES (NOW(), ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $tracking_num);
        $stmt->bindParam(2, $siteCode);
        $stmt->bindParam(3, $hw_id);
        $stmt->bindParam(4, $user_id);
        $stmt->bindParam(5, $datePullout);

    }
}