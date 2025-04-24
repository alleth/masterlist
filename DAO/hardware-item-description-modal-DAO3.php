<?php
include "BaseDAO.php";

class hardwareItemDescription3DAO extends BaseDAO {
    function hardwareItemDescription3(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_description");
        $stmt->execute();

        echo "<select id='itemSelect3' class='form-select' name='itemSelect3' onchange='hardware_brand_option2()' required>";
        echo "<option value='' selected></option>";
        while ($row3 = $stmt->fetch()){
            echo "<option value='".$row3[1]."' onchange=''>".$row3[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}