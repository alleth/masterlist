<?php
require_once 'BaseDAO.php';

class DeleteItemModelDAO extends BaseDAO {
    public function deleteModelByID($id) {
        try {
            $this->openConn();

            $stmt = $this->dbh->prepare("DELETE FROM item_models WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'message' => 'Model deleted successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'Model not found or already deleted.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'DB Error: ' . $e->getMessage()];
        }
    }
}
