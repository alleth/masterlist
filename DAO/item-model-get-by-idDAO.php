<?php
require_once 'BaseDAO.php';

class ItemModelDAO extends BaseDAO {
    public function getModelById($id) {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_models WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->closeConn();
        return $result;
    }
}
