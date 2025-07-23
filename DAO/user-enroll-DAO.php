<?php
include "BaseDAO.php";

class addUserDAO extends BaseDAO {
    function addUserData($data) {
        try {
            $this->openConn();

            $username = trim(strtolower($data['user_name']));
            $passwordInput = isset($data['user_pass']) ? trim($data['user_pass']) : '';

            // Check if the user already exists
            $check = $this->dbh->prepare("SELECT COUNT(*) FROM user_tbl WHERE LOWER(user_name) = ?");
            $check->execute([$username]);
            if ($check->fetchColumn() > 0) {
                echo json_encode(['error' => 'Username already exists.']);
                $this->closeConn();
                return;
            }

            // Use hashed password
            $defaultPassword = $passwordInput !== '' ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash('password', PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $this->dbh->prepare("
                INSERT INTO user_tbl (fname, lname, region_assigned, user_type, cluster_name, user_name, user_pass, profile_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([
                $data['fname'],
                $data['lname'],
                $data['region_assigned'] ?: null,
                $data['user_type'],
                $data['cluster_name'] ?: null,
                $username,
                $defaultPassword,
                'assets/img/avatar.png'
            ]);

            if (!$result) {
                throw new Exception('Insert failed: ' . implode(', ', $stmt->errorInfo()));
            }

            // Log the activity (use session user_id if available)
            $user_id = isset($_SESSION['sess_id']) ? $_SESSION['sess_id'] : 'unknown';
            $insert_activity = "User Enrollment";
            $activity_status = "Completed";
            $insert_log = $this->dbh->prepare("
                INSERT INTO log_tbl (log_date, log_activity, log_user, log_status) 
                VALUES (NOW(), ?, ?, ?)
            ");
            $insert_log->execute([$insert_activity, $user_id, $activity_status]);

            // Fetch region name for response
            $region_get = 'All Region';
            if ($data['region_assigned']) {
                $region_fetch = $this->dbh->prepare("SELECT region_name FROM region_tbl WHERE region_id = ?");
                $region_fetch->execute([$data['region_assigned']]);
                $region_row = $region_fetch->fetch();
                $region_get = $region_row ? $region_row['region_name'] : 'Unknown';
            }

            // Prepare the success response
            $response = [
                "success" => true,
                "message" => "User enrolled successfully!",
                "new_user" => [
                    "fname" => $data['fname'],
                    "lname" => $data['lname'],
                    "region" => $region_get,
                    "user_type" => $data['user_type'],
                    "cluster" => $data['cluster_name'] ?: 'All Cluster',
                    "user_name" => $username
                ]
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            error_log("addUserDAO::addUserData error: " . $e->getMessage() . " | Data: " . json_encode($data), 3, 'user_errors.log');
            echo json_encode(['error' => 'Failed to enroll user: ' . $e->getMessage()]);
        } finally {
            $this->closeConn();
        }
    }
}

// Handle request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    $dao = new addUserDAO();
    $dao->addUserData($_POST);
}
?>