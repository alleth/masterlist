<?php
require_once 'BaseDAO.php';

class UserDAO extends BaseDAO {

    public function updateUserInfo($userId, $data) {
        try {
            $this->openConn();
            $sql = "UPDATE user_tbl 
                    SET fname = ?, lname = ?, user_name = ?
                    WHERE id = ?";
            $stmt = $this->dbh->prepare($sql);
            return $stmt->execute([
                $data['fname'], $data['lname'], $data['user_name'], $userId
            ]);
        } catch (PDOException $e) {
            error_log('Update user info error: ' . $e->getMessage());
            return false;
        }
    }

    public function changePassword($userId, $currentPassword, $newPassword) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT user_pass FROM user_tbl WHERE id = ?");
            $stmt->execute([$userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row || !password_verify($currentPassword, $row['user_pass'])) {
                return false;
            }

            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $this->dbh->prepare("UPDATE user_tbl SET user_pass = ? WHERE id = ?");
            return $updateStmt->execute([$hashed, $userId]);
        } catch (PDOException $e) {
            error_log('Change password error: ' . $e->getMessage());
            return false;
        }
    }

    public function getUserDetails($userId) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("
                SELECT u.fname, u.lname, r.region_name AS region_assigned, u.user_type, u.cluster_name, u.user_name, u.profile_picture
                FROM user_tbl u
                LEFT JOIN region_tbl r ON u.region_assigned = r.region_id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Get user details error: ' . $e->getMessage());
            return null;
        }
    }

    public function verifyPassword($userId, $password) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT user_pass FROM user_tbl WHERE id = ?");
            $stmt->execute([$userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row && password_verify($password, $row['user_pass']);
        } catch (PDOException $e) {
            error_log('Verify password error: ' . $e->getMessage());
            return false;
        }
    }

    public function checkUsernameExists($userId, $username) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT id FROM user_tbl WHERE user_name = ? AND id != ?");
            $stmt->execute([$username, $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log('Check username exists error: ' . $e->getMessage());
            return false;
        }
    }
}
?>