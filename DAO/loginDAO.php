<?php
include "BaseDAO.php";

class loginUserDAO extends BaseDAO {
    /**
     * @var PDO|null The database connection handle
     */
    protected $dbh;

    function loginUser($user_name, $user_password) {
        try {
            $this->openConn();

            // Check if user is locked
            $stmt = $this->dbh->prepare("SELECT * FROM user_tbl WHERE user_name = ?");
            $stmt->bindParam(1, $user_name);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Check lockout status
                if ($row['lockout_until'] !== null && strtotime($row['lockout_until']) > time()) {
                    $this->closeConn();
                    return -1; // Account is locked
                }

                // Verify password
                if (password_verify($user_password, $row['user_pass'])) {
                    // Reset failed attempts on successful login
                    $stmt = $this->dbh->prepare("UPDATE user_tbl SET failed_attempts = 0, lockout_until = NULL WHERE user_name = ?");
                    $stmt->bindParam(1, $user_name);
                    $stmt->execute();

                    // Set session variables
                    $_SESSION['sess_id'] = $row['id'];
                    $_SESSION['sess_fname'] = $row['fname'];
                    $_SESSION['sess_lname'] = $row['lname'];
                    $_SESSION['sess_assigned'] = $row['region_assigned'];
                    $_SESSION['sess_user_type'] = $row['user_type'];
                    $_SESSION['sess_cluster'] = $row['cluster_name'];
                    $_SESSION['last_activity'] = time(); // Track last activity for auto-logout
                    $this->closeConn();
                    return 1; // Successful login
                } else {
                    // Increment failed attempts
                    $failed_attempts = $row['failed_attempts'] + 1;
                    if ($failed_attempts >= 3) {
                        // Lock account for 1 minute
                        $lockout_until = date('Y-m-d H:i:s', time() + 60);
                        $stmt = $this->dbh->prepare("UPDATE user_tbl SET failed_attempts = ?, lockout_until = ? WHERE user_name = ?");
                        $stmt->bindParam(1, $failed_attempts, PDO::PARAM_INT);
                        $stmt->bindParam(2, $lockout_until);
                        $stmt->bindParam(3, $user_name);
                        $stmt->execute();
                        $this->closeConn();
                        return -1; // Account locked
                    } else {
                        // Update failed attempts
                        $stmt = $this->dbh->prepare("UPDATE user_tbl SET failed_attempts = ? WHERE user_name = ?");
                        $stmt->bindParam(1, $failed_attempts, PDO::PARAM_INT);
                        $stmt->bindParam(2, $user_name);
                        $stmt->execute();
                        $this->closeConn();
                        return 0; // Password mismatch
                    }
                }
            } else {
                $this->closeConn();
                return 0; // User not found
            }
        } catch (Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            $this->closeConn();
            return 0;
        }
    }

    // New method to get lockout timestamp
    function getLockoutUntil($user_name) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT lockout_until FROM user_tbl WHERE user_name = ?");
            $stmt->bindParam(1, $user_name);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->closeConn();
            return $row && $row['lockout_until'] ? strtotime($row['lockout_until']) : null;
        } catch (Exception $e) {
            error_log("Lockout check error: " . $e->getMessage());
            $this->closeConn();
            return null;
        }
    }
}