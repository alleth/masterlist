<?php
include "BaseDAO.php";

class addUserDAO extends BaseDAO {
    function addUserData($f_name, $l_name, $region_name, $clusterName, $user_type, $user_name, $user_id) {
        $this->openConn();

        // Check if the user already exists
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
            // Insert new user into the database
            $user_pass = "password"; // Default password
            $stmt2 = $this->dbh->prepare("
                INSERT INTO user_tbl (fname, lname, region_assigned, user_type, cluster_name, user_name, user_pass) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt2->bindParam(1, $f_name);
            $stmt2->bindParam(2, $l_name);
            $stmt2->bindParam(3, $region_name);
            $stmt2->bindParam(4, $user_type);
            $stmt2->bindParam(5, $clusterName);
            $stmt2->bindParam(6, $user_name);
            $stmt2->bindParam(7, $user_pass);
            $stmt2->execute();

            // Log the activity
            $insert_activity = "User Enrollment";
            $activity_status = "Completed";
            $insert_log = $this->dbh->prepare("
                INSERT INTO log_tbl (log_date, log_activity, log_user, log_status) 
                VALUES (NOW(), ?, ?, ?)
            ");
            $insert_log->bindParam(1, $insert_activity);
            $insert_log->bindParam(2, $user_id);
            $insert_log->bindParam(3, $activity_status);
            $insert_log->execute();


            $region_fetch = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_fetch->bindParam(1, $region_name);
            $region_fetch->execute();

            while($region_row = $region_fetch->fetch()){
                $region_get = $region_row[1];
            }

            // Prepare the success response
            $response = [
                "success" => true,
                "message" => "User enrolled successfully!",
                "new_user" => [
                    "fname" => $f_name,
                    "lname" => $l_name,
                    "region" => $region_get,
                    "user_type" => $user_type,
                    "cluster" => $clusterName,
                    "user_name" => $user_name
                ]
            ];
        }

        // Encode response as JSON and send it back
        $json_string = json_encode($response);
        echo $json_string;

        $this->closeConn();
    }
}
