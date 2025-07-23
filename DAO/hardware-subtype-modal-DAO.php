<?php
include "BaseDAO.php";

class SubTypeDAO extends BaseDAO {
    public function getSubTypeByItemDesc($item_desc) {
        $this->openConn();

        $stmt = $this->dbh->prepare("SELECT sub_major_type FROM item_description WHERE item_desc = :item_desc LIMIT 1");
        $stmt->bindParam(':item_desc', $item_desc);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->closeConn();

        return $result ?: ['sub_major_type' => ''];
    }
}
