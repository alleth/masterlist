<?php

include "BaseDAO.php";

class ModelHandler extends BaseDAO {
    public function getModelsByItemAndBrand($item_desc, $brand) {
        $this->openConn();

        $query = "SELECT DISTINCT model FROM item_models 
                  WHERE item_desc = :item_desc AND brand = :brand 
                  ORDER BY model ASC";

        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':item_desc', $item_desc);
        $stmt->bindParam(':brand', $brand);
        $stmt->execute();

        $models = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->closeConn();
        return $models;
    }
}
?>