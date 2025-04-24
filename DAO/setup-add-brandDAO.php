<?php
include "BaseDAO.php";

class addItemBrandDAO extends BaseDAO {
    function addItemBrand($itemSelect2, $item_brand_add) {
        $this->openConn();

            $stmt = $this->dbh->prepare("INSERT INTO item_brand (item_desc, brand) VALUES (?, ?) ");
            $stmt->bindParam(1, $itemSelect2);
            $stmt->bindParam(2, $item_brand_add);
            $stmt->execute();

        $this->closeConn();
    }
}