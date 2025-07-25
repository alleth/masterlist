<?php
include_once 'BaseDAO.php';
include "../auth.php";

// Suppress PHP warnings to ensure clean JSON output
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

class UserDAO extends BaseDAO {
    public function getAllUsers() {
        try {
            $getUserType = $_SESSION['sess_user_type'] ?? '';
            $getCluster = $_SESSION['sess_cluster'] ?? '';
            $getUserId = $_SESSION['sess_id'] ?? 0;
            $this->openConn();

            if ($getUserType == "ADM") {
                $sql = "SELECT u.*, r.region_name 
                        FROM user_tbl u 
                        LEFT JOIN region_tbl r ON u.region_assigned = r.region_id";
                $stmt = $this->dbh->query($sql);
            } else {
                $sql = "SELECT u.*, r.region_name 
                        FROM user_tbl u 
                        LEFT JOIN region_tbl r ON u.region_assigned = r.region_id 
                        WHERE u.cluster_name = :cluster AND u.id != :userid";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute([
                    ':cluster' => $getCluster,
                    ':userid' => $getUserId
                ]);
            }

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeConn();

            foreach ($users as $user) {
                $userTypeDisplay = match($user['user_type'] ?? '') {
                    'ADM' => "<span class='badge bg-danger'>Administrator</span>",
                    'SPV' => "<span class='badge bg-warning text-dark'>Supervisor</span>",
                    default => "<span class='badge bg-primary'>FSE</span>",
                };

                $displayButton = $getUserType === "ADM"
                    ? "<button class='btn btn-sm btn-info edit-btn' data-id='{$user['id']}'>Edit</button>
                       <button class='btn btn-sm btn-danger delete-btn' data-id='{$user['id']}'>Delete</button>"
                    : "<span class='badge bg-warning text-dark fa fa-lock'></span>";

                // Handle NULL values
                $fullName = ($user['fname'] ?? '') . ' ' . ($user['lname'] ?? '');
                $fullName = trim($fullName) !== '' ? htmlspecialchars($fullName) : 'N/A';
                $regionName = $user['region_name'] ?? ($user['region_assigned'] == '0' ? 'All Region' : 'N/A');
                $clusterName = $user['cluster_name'] ?? 'N/A';
                $userName = $user['user_name'] ?? 'N/A';

                echo "<tr>
                    <td>$fullName</td>
                    <td>" . htmlspecialchars($regionName) . "</td>
                    <td>" . htmlspecialchars($clusterName) . "</td>
                    <td>$userTypeDisplay</td>
                    <td>" . htmlspecialchars($userName) . "</td>
                    <td>$displayButton</td>
                  </tr>";
            }
        } catch (Exception $e) {
            error_log("UserDAO::getAllUsers error: " . $e->getMessage(), 3, 'user_errors.log');
            echo "<tr><td colspan='6'>Error loading users: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
    }

    public function getUser($id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("
                SELECT u.*, r.region_name 
                FROM user_tbl u 
                LEFT JOIN region_tbl r ON u.region_assigned = r.region_id 
                WHERE u.id = ?
            ");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->closeConn();

            if (!$user) {
                echo json_encode(['error' => 'User not found']);
                return;
            }

            unset($user['user_pass']);
            echo json_encode($user);
        } catch (Exception $e) {
            error_log("UserDAO::getUser error: " . $e->getMessage(), 3, 'user_errors.log');
            echo json_encode(['error' => 'Failed to fetch user: ' . $e->getMessage()]);
        }
    }

    public function saveUser($data) {
        try {
            $this->openConn();

            $username = trim(strtolower($data['user_name'] ?? ''));
            $passwordInput = isset($data['user_pass']) ? trim($data['user_pass']) : '';
            $user_type = $data['user_type'] ?? '';
            $region_id = isset($data['region_assigned']) && $data['region_assigned'] !== '' ? $data['region_assigned'] : null;
            $cluster_name = isset($data['cluster_name']) && $data['cluster_name'] !== '' ? $data['cluster_name'] : ($user_type === 'ADM' ? 'All Cluster' : null);

            // Validate required fields
            if (empty($data['fname']) || empty($data['lname']) || empty($user_type) || empty($username)) {
                echo json_encode(['error' => 'Missing required fields: fname, lname, user_type, or user_name']);
                $this->closeConn();
                return;
            }

            // For ADM and SPV, set region_id to "All Region"
            if ($user_type === 'ADM' || $user_type === 'SPV') {
                $stmt = $this->dbh->prepare("SELECT region_id FROM region_tbl WHERE region_name = 'All Region'");
                $stmt->execute();
                $region_id = $stmt->fetchColumn();
                if ($region_id === false) {
                    // Fallback: Insert "All Region" if missing
                    $stmt = $this->dbh->prepare("INSERT INTO region_tbl (region_id, region_name, cluster_name) VALUES (0, 'All Region', NULL)");
                    $stmt->execute();
                    $region_id = '0';
                    error_log("saveUser: Inserted 'All Region' with region_id = 0", 3, 'user_errors.log');
                }
            }

            // For FSE, ensure region_id and cluster_name are valid
            if ($user_type === 'FSE') {
                if (empty($cluster_name)) {
                    echo json_encode(['error' => 'Cluster is required for FSE']);
                    $this->closeConn();
                    return;
                }
                if ($region_id === null || $region_id === '') {
                    echo json_encode(['error' => 'Region is required for FSE']);
                    $this->closeConn();
                    return;
                }
                $stmt = $this->dbh->prepare("SELECT region_id FROM region_tbl WHERE region_id = ? AND region_name != 'All Region'");
                $stmt->execute([$region_id]);
                if ($stmt->fetchColumn() === false) {
                    echo json_encode(['error' => 'Invalid region selected for FSE']);
                    $this->closeConn();
                    return;
                }
            }

            if (empty($data['id'])) {
                // Check for duplicate username
                $check = $this->dbh->prepare("SELECT COUNT(*) FROM user_tbl WHERE LOWER(user_name) = ?");
                $check->execute([$username]);
                if ($check->fetchColumn() > 0) {
                    echo json_encode(['error' => 'Username already exists']);
                    $this->closeConn();
                    return;
                }

                $defaultPassword = $passwordInput !== '' ? password_hash($passwordInput, PASSWORD_DEFAULT) : password_hash('password', PASSWORD_DEFAULT);

                $stmt = $this->dbh->prepare("INSERT INTO user_tbl 
                    (fname, lname, region_assigned, cluster_name, user_type, user_name, user_pass, profile_picture, failed_attempts) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
                $result = $stmt->execute([
                    $data['fname'],
                    $data['lname'],
                    $region_id,
                    $cluster_name,
                    $user_type,
                    $username,
                    $defaultPassword,
                    'assets/img/avatar.png'
                ]);

                if (!$result) {
                    throw new Exception('Insert failed: ' . implode(', ', $stmt->errorInfo()));
                }

                echo json_encode(['success' => true]);
            } else {
                // Check for duplicate username (excluding current user)
                $check = $this->dbh->prepare("SELECT COUNT(*) FROM user_tbl WHERE LOWER(user_name) = ? AND id != ?");
                $check->execute([$username, $data['id']]);
                if ($check->fetchColumn() > 0) {
                    echo json_encode(['error' => 'Username already exists']);
                    $this->closeConn();
                    return;
                }

                $stmt = $this->dbh->prepare("UPDATE user_tbl 
                    SET fname = ?, lname = ?, region_assigned = ?, cluster_name = ?, user_type = ?, user_name = ?
                    WHERE id = ?");
                $result = $stmt->execute([
                    $data['fname'],
                    $data['lname'],
                    $region_id,
                    $cluster_name,
                    $user_type,
                    $username,
                    $data['id']
                ]);

                if (!$result) {
                    throw new Exception('Update failed: ' . implode(', ', $stmt->errorInfo()));
                }

                echo json_encode(['success' => true]);
            }
        } catch (Exception $e) {
            error_log("UserDAO::saveUser error: " . $e->getMessage() . " | Data: " . json_encode($data), 3, 'user_errors.log');
            echo json_encode(['error' => 'Failed to save user: ' . $e->getMessage()]);
        } finally {
            $this->closeConn();
        }
    }

    public function deleteUser($id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("DELETE FROM user_tbl WHERE id = ?");
            $result = $stmt->execute([$id]);
            if (!$result) {
                throw new Exception('Delete failed: ' . implode(', ', $stmt->errorInfo()));
            }
            $this->closeConn();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            error_log("UserDAO::deleteUser error: " . $e->getMessage(), 3, 'user_errors.log');
            echo json_encode(['error' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }

    public function getAllRegions() {
        try {
            $this->openConn();
            $stmt = $this->dbh->query("SELECT region_id, region_name FROM region_tbl ORDER BY region_name");
            $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeConn();
            echo json_encode($regions);
        } catch (Exception $e) {
            error_log("UserDAO::getAllRegions error: " . $e->getMessage(), 3, 'user_errors.log');
            echo json_encode(['error' => 'Failed to fetch regions: ' . $e->getMessage()]);
        }
    }

    public function getRegionsByCluster($cluster) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT region_id, region_name FROM region_tbl WHERE (cluster_name = ? OR cluster_name IS NULL) AND region_name != 'All Region' ORDER BY region_name");
            $stmt->execute([$cluster]);
            $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeConn();
            echo json_encode($regions);
        } catch (Exception $e) {
            error_log("UserDAO::getRegionsByCluster error: " . $e->getMessage(), 3, 'user_errors.log');
            echo json_encode(['error' => 'Failed to fetch regions by cluster: ' . $e->getMessage()]);
        }
    }
}

$dao = new UserDAO();

ob_start(); // Start output buffering
switch ($_POST['action']) {
    case 'fetch':
        $dao->getAllUsers();
        break;
    case 'edit':
        $dao->getUser($_POST['id']);
        break;
    case 'save':
        $dao->saveUser($_POST);
        break;
    case 'delete':
        $dao->deleteUser($_POST['id']);
        break;
    case 'fetch_regions':
        $dao->getAllRegions();
        break;
    case 'fetch_regions_by_cluster':
        $dao->getRegionsByCluster($_POST['cluster']);
        break;
}
ob_end_flush(); // Send output and clean buffer
?>