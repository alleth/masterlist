<?php
include "BaseDAO.php";

class hardwareItemDescriptionDAO extends BaseDAO {
    function hardwareItemDescription(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_description");
        $stmt->execute();

        echo "<select id='itemSelect' class='form-select' name='itemSelect' onchange='hardware_brand_option(); hardware_model_option()' required>";
        echo "<option value='' selected></option>";
        while ($row3 = $stmt->fetch()){
            echo "<option value='".$row3[1]."' onchange=''>".$row3[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}