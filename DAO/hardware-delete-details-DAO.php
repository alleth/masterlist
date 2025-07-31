<?php

include_once "BaseDAO.php";

class HardwarePulloutDAO extends BaseDAO {
    public function pulloutById($hw_id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("UPDATE hw_tbl SET hw_status = 'Pullout' WHERE hw_id = :hw_id");
            $stmt->bindParam(':hw_id', $hw_id, PDO::PARAM_INT);
            $stmt->execute();
            $this->closeConn();
            echo "success";
        } catch (PDOException $e) {
            $this->closeConn();
            echo "error";
        }
    }
}

/*
include_once "BaseDAO.php";

class HardwareDeleteDAO extends BaseDAO {
    public function deleteById($hw_id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("DELETE FROM hw_tbl WHERE hw_id = :hw_id");
            $stmt->bindParam(':hw_id', $hw_id, PDO::PARAM_INT);
            $stmt->execute();
            $this->closeConn();
            echo "success";
        } catch (PDOException $e) {
            $this->closeConn();
            echo "error";
        }
    }
}
*/