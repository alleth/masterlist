<?php
include "BaseDAO.php";
class trackingNumAddDAO extends BaseDAO {
    function trackingNumAdd($tracking_num, $hw_id_pullout, $user_id, $cluster_name){
        $site_code = "";
        // Basic validation
        if (empty($tracking_num) || empty($hw_id_pullout) || empty($user_id)) {
            throw new Exception("All fields are required.");
        }

        $this->openConn();

        $show_hw = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $show_hw->bindParam(1, $hw_id_pullout);
        $show_hw->execute();

        while ($row = $show_hw->fetch()){
            $site_code = $row[2];
        }

        // Insert into tracking_tbl
        $pullout_hw = $this->dbh->prepare("INSERT INTO tracking_tbl (tracking_date, tracking_num, site_code, hw_id, user_id, cluster_name) VALUES (NOW(), ?, ?, ?, ?, ?)");
        $pullout_hw->bindParam(1, $tracking_num);
        $pullout_hw->bindParam(2, $site_code);
        $pullout_hw->bindParam(3, $hw_id_pullout);
        $pullout_hw->bindParam(4, $user_id);
        $pullout_hw->bindParam(5, $cluster_name);
        $success1 = $pullout_hw->execute();

        if (!$success1) {
            $this->closeConn();
            throw new Exception("Failed to insert into tracking_tbl.");
        }

        // Update hw_tbl
        $hw_status = "Pending";
        $update_status = $this->dbh->prepare("UPDATE hw_tbl SET hw_status = ?, user_id = ? WHERE hw_id = ?");
        $update_status->bindParam(1, $hw_status);
        $update_status->bindParam(2, $user_id);
        $update_status->bindParam(3, $hw_id_pullout);
        $success2 = $update_status->execute();

        if (!$success2) {
            $this->closeConn();
            throw new Exception("Failed to update hw_tbl.");
        }

        // Insert into log_tbl
        $log_activity = "Request hardware pull out";
        $log_status = "Pending";
        $log_stmt = $this->dbh->prepare("INSERT INTO log_tbl (log_date, log_activity, log_user, log_status) VALUES (NOW(), ?, ?, ?)");
        $log_stmt->bindParam(1, $log_activity);
        $log_stmt->bindParam(2, $user_id);
        $log_stmt->bindParam(3, $log_status);
        $success3 = $log_stmt->execute();

        if (!$success3) {
            $this->closeConn();
            throw new Exception("Failed to insert into log_tbl.");
        }
        $this->closeConn();
        return true; // Indicate success
    }
}