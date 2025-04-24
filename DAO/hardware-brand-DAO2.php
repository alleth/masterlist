<?php
include "BaseDAO.php";

class hardwareBrand2DAO extends BaseDAO{
    function hardwareBrand2($item_name2){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_brand WHERE item_desc = ? ORDER BY brand");
        $stmt->bindParam(1, $item_name2);
        $stmt->execute();

        while ($row4 = $stmt->fetch()){
            echo "<option value='".$row4[2]."' onchange=''>".$row4[2]."</option>";
        }
    }
}
?>