<?php
include "BaseDAO.php";

class addItemDescDAO extends BaseDAO {
    function addItemDesc($item_desc_add) {
        $this->openConn();

            $stmt = $this->dbh->prepare("INSERT INTO item_description (item_desc) VALUES (?) ");
            $stmt->bindParam(1, $item_desc_add);
            $stmt->execute();

        $this->closeConn();
    }
}