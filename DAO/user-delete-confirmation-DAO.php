<?php
include "BaseDAO.php";

class deleteUserDAO extends BaseDAO {
    function deleteUser($user_id, $sess_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("DELETE FROM user_tbl WHERE id = ?");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        $insert_activity = "Deleted a user.";
        $activity_status = "Completed";
        $insert_log = $this->dbh->prepare("INSERT INTO log_tbl (log_date, log_activity, log_user, log_status) VALUES (NOW(), ?, ?, ?)");
        $insert_log->bindParam(1, $insert_activity);
        $insert_log->bindParam(2, $sess_id);
        $insert_log->bindParam(3, $activity_status);
        $insert_log->execute();

        $this->closeConn();
    }
}