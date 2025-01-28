<?php
include "BaseDAO.php";

class loginUserDAO extends BaseDAO {
    function loginUser($user_name, $user_password) {
        try {
            $this->openConn();

            $stmt = $this->dbh->prepare("SELECT * FROM user_tbl WHERE user_name = ?");
            $stmt->bindParam(1, $user_name);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if ($user_password == $row['user_pass']) {
                    $_SESSION['sess_id'] = $row['id'];
                    $_SESSION['sess_fname'] = $row['fname'];
                    $_SESSION['sess_lname'] = $row['lname'];
                    $_SESSION['sess_assigned'] = $row['region_assigned'];
                    $_SESSION['sess_user_type'] = $row['user_type'];
                    $_SESSION['sess_cluster'] = $row['cluster_name'];
                    $this->closeConn();
                    return 1;
                } else {
                    $this->closeConn();
                    return 0;
                }
            } else {
                $this->closeConn();
                return 0; // User not found
            }
        } catch (Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            return 0;
        }
    }
}
