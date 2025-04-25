<?php
include_once 'BaseDAO.php';
include "../auth.php";
class UserDAO extends BaseDAO {
    public function getAllUsers() {
        $getUserType = $_SESSION['sess_user_type'];
        $this->openConn();

        // Fetch users with region name via JOIN
        $sql = "SELECT u.*, r.region_name 
            FROM user_tbl u 
            LEFT JOIN region_tbl r ON u.region_assigned = r.region_id";
        $stmt = $this->dbh->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->closeConn();

        foreach ($users as $user) {
            // Display user type badge
            $userTypeDisplay = match($user['user_type']) {
                'ADM' => "<span class='badge bg-danger'>Administrator</span>",
                'SPV' => "<span class='badge bg-warning text-dark'>Supervisor</span>",
                default => "<span class='badge bg-primary'>FSE</span>",
            };

            // Display action buttons only for admin
            $displayButton = $getUserType === "ADM"
                ? "<button class='btn btn-sm btn-info edit-btn' data-id='{$user['id']}'>Edit</button>
               <button class='btn btn-sm btn-danger delete-btn' data-id='{$user['id']}'>Delete</button>"
                : "<span class='badge bg-warning text-dark fa fa-lock'></span>";

            echo "<tr>
                <td>{$user['fname']} {$user['lname']}</td>
                <td>{$user['region_name']}</td>
                <td>{$user['cluster_name']}</td>
                <td>{$userTypeDisplay}</td>
                <td>{$user['user_name']}</td>
                <td>{$displayButton}</td>
              </tr>";
        }
    }


    public function getUser($id) {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM user_tbl WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->closeConn();

        echo json_encode($user);
    }

    public function saveUser($data) {
        $this->openConn();

        if (!empty($data['id'])) {
            $stmt = $this->dbh->prepare("UPDATE user_tbl SET fname=?, lname=?, region_assigned=?, cluster_name=?, user_type=?, user_name=?, user_pass=? WHERE id=?");
            $stmt->execute([
                $data['fname'],
                $data['lname'],
                $data['region_assigned'],
                $data['cluster_name'],
                $data['user_type'],
                $data['user_name'],
                $data['user_pass'],
                $data['id']
            ]);
        } else {
            $stmt = $this->dbh->prepare("INSERT INTO user_tbl (fname, lname, region_assigned, cluster_name, user_type, user_name, user_pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['fname'],
                $data['lname'],
                $data['region_assigned'],
                $data['cluster_name'],
                $data['user_type'],
                $data['user_name'],
                $data['user_pass']
            ]);
        }

        $this->closeConn();
    }

    public function deleteUser($id) {
        $this->openConn();
        $stmt = $this->dbh->prepare("DELETE FROM user_tbl WHERE id = ?");
        $stmt->execute([$id]);
        $this->closeConn();
    }
}

// Action handler
$dao = new UserDAO();

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
}
