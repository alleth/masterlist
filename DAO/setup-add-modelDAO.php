<?php
include "BaseDAO.php";

class addItemModelDAO extends BaseDAO {
    function addItemModel($itemSelect3, $itemBrand2, $item_model_add) {
        $this->openConn();

            $stmt = $this->dbh->prepare("INSERT INTO item_models (item_desc, brand, model) VALUES (?, ?, ?) ");
            $stmt->bindParam(1, $itemSelect3);
            $stmt->bindParam(2, $itemBrand2);
            $stmt->bindParam(3, $item_model_add);
            $stmt->execute();

        $this->closeConn();
    }
}