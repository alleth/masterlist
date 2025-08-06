<?php
require_once 'BaseDAO.php';

class ItemBrandDeleteDAO extends BaseDAO {
    public function deleteItemBrand($id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("DELETE FROM item_brand WHERE id = ?");
            $stmt->execute([$id]);
            $this->closeConn();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Optional: log error
            return false;
        }
    }
}
