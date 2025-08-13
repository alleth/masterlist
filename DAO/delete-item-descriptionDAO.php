<?php
require_once 'BaseDAO.php';

class DeleteItemDescriptionDAO extends BaseDAO {

    public function deleteItem($id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("DELETE FROM item_description WHERE item_id = ?");
            $stmt->execute([$id]);
            $this->closeConn();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
