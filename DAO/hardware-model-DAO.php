<?php
include "BaseDAO.php";

class hardwareModelDAO extends BaseDAO{
    function hardwareModel($model_item_name){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_models WHERE item_desc = ? ORDER BY model");
        $stmt->bindParam(1, $model_item_name);
        $stmt->execute();

        while ($row6 = $stmt->fetch()){
            echo "<option value='".$row6[3]."' onchange=''>".$row6[3]."</option>";
        }
    }
}

?>