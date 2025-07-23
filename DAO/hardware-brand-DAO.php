<?php
include "BaseDAO.php";

class BrandHandler extends BaseDAO {
    public function getBrandsByItem($item_desc) {
        $this->openConn();

        $query = "SELECT DISTINCT brand FROM item_brand WHERE item_desc = :item_desc ORDER BY brand ASC";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':item_desc', $item_desc);
        $stmt->execute();

        $brands = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->closeConn();
        return $brands;
    }
}

?>
