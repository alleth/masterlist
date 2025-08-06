<?php
require_once 'BaseDAO.php';

class UpdateItemModelDAO extends BaseDAO {
    public function updateItemModel($id, $model) {
        $this->openConn();

        $stmt = $this->dbh->prepare("UPDATE item_models SET model = :model WHERE id = :id");
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':id', $id);

        $result = $stmt->execute();

        $this->closeConn();
        return $result;
    }
}
?>
