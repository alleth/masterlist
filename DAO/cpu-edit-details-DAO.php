<?php
include "BaseDAO.php";
class cpuEditDetailsDAO extends BaseDAO{

    function cpuEditDetails($hw_id,
                            $brand_name,
                            $model_name,
                            $asset_num,
                            $serial_num,
                            $date_acquired,
                            $hw_status,
                            $host_name,
                            $ip_add,
                            $mac_add,
                            $hw_user,
                            $primary_role,
                            $user_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("UPDATE hw_tbl SET 
                                     hw_brand_name = ?, 
                                     hw_model = ?, 
                                     hw_asset_num = ?, 
                                     hw_serial_num = ?, 
                                     hw_year_acq = ?, 
                                     hw_status = ?, 
                                     hw_host_name = ?, 
                                     hw_ip_add = ?, 
                                     hw_mac_add = ?, 
                                     hw_user_name = ?, 
                                     hw_primary_role = ?, 
                                     user_id = ?
                                     WHERE 
                                     hw_id = ?");
        $stmt->bindParam(1, $brand_name);
        $stmt->bindParam(2, $model_name);
        $stmt->bindParam(3, $asset_num);
        $stmt->bindParam(4, $serial_num);
        $stmt->bindParam(5, $date_acquired);
        $stmt->bindParam(6, $hw_status);
        $stmt->bindParam(7, $host_name);
        $stmt->bindParam(8, $ip_add);
        $stmt->bindParam(9, $mac_add);
        $stmt->bindParam(10, $hw_user);
        $stmt->bindParam(11, $primary_role);
        $stmt->bindParam(12, $user_id);
        $stmt->bindParam(13, $hw_id);

        if ($stmt->execute()) {
            $insert_activity = "Update hardware details";
            $activity_status = "Completed";
            $insert_log = $this->dbh->prepare("INSERT INTO log_tbl (log_date, log_activity, log_user, log_status) VALUES (NOW(), ?, ?, ?)");
            $insert_log->bindParam(1, $insert_activity);
            $insert_log->bindParam(2, $user_id);
            $insert_log->bindParam(3, $activity_status);

            if ($insert_log->execute()) {
                echo "Log entry created successfully.";
            } else {
                echo "Error creating log entry.";
            }
        } else {
            echo "Error updating hardware details.";
        }

        $this->closeConn();
    }
}
