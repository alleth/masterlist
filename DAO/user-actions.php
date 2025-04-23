<?php
include_once 'BaseDAO.php';
include "../auth.php";
class UserDAO extends BaseDAO {
    public function getAllUsers() {
        $getUserType = "ADM";
        $userTypeDisplay = "";
        $this->openConn();
        $stmt = $this->dbh->query("SELECT * FROM user_tbl");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConn();

        foreach ($users as $user) {
            $user_type = "{$user['user_type']}";

            if($user_type == "ADM"){
                $userTypeDisplay = "<span class='badge bg-danger'>Administrator</span>";
            }else if($user_type == "SPV"){
                $userTypeDisplay = "<span class='badge bg-warning'>Supervisor</span>";
            }else{
                $userTypeDisplay = "<span class='badge bg-primary'>FSE</span>";
            }
            if($user_type == $getUserType){
                $displayButton = "";
            }else{
                $displayButton = "<button class='btn btn-sm btn-info edit-btn' data-id='{$user['id']}'>Edit</button>
                        <button class='btn btn-sm btn-danger delete-btn' data-id='{$user['id']}'>Delete</button>";
            }
            echo "<tr>
                    <td>{$user['fname']} {$user['lname']}</td>
                    <td>{$user['region_assigned']}</td>
                    <td>{$user['cluster_name']}</td>
                    <td>$userTypeDisplay</td>
                    <td>{$user['user_name']}</td>
                    <td>
                        $displayButton
                    </td>
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
