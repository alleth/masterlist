<?php
include "BaseDAO.php";
class addUserDAO extends BaseDAO {
    function addUserData($f_name, $l_name, $region_name, $clusterName, $user_type, $user_name, $user_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM user_tbl WHERE fname = ? AND lname = ? AND user_name = ?");
        $stmt->bindParam(1, $f_name);
        $stmt->bindParam(2, $l_name);
        $stmt->bindParam(3, $user_name);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // User already exists
            $response = [
                "exists" => true,
                "message" => "This user already exists in the system."
            ];
        } else {
            // Insert new user
            $user_pass = "password";
            $stmt2 = $this->dbh->prepare("INSERT INTO user_tbl (fname, lname, region_assigned, user_type, cluster_name, user_name, user_pass) VALUES (?, ?, ?, ?, ?, ?,?)");
            $stmt2->bindParam(1, $f_name);
            $stmt2->bindParam(2, $l_name);
            $stmt2->bindParam(3, $region_name);
            $stmt2->bindParam(4, $user_type);
            $stmt2->bindParam(5, $clusterName);
            $stmt2->bindParam(6, $user_name);
            $stmt2->bindParam(7, $user_pass);
            $stmt2->execute();

            $insert_activity = "User Enrollment";
            $activity_status = "Completed";
            $insert_log = $this->dbh->prepare("INSERT INTO log_tbl (log_date, log_activity, log_user, log_status) VALUES (NOW(), ?, ?, ?)");
            $insert_log->bindParam(1, $insert_activity);
            $insert_log->bindParam(2, $user_id);
            $insert_log->bindParam(3, $activity_status);
            $insert_log->execute();

            $response = [
                "success" => true,
                "message" => "User enrolled successfully!"
            ];
        }
        $json_string = json_encode($response);
        echo $json_string;

        $this->closeConn();

    }
}