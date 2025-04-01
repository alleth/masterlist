<?php
include "BaseDAO.php";

class hardwareModelDAO extends BaseDAO {
    function hardwareModel(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_models");
        $stmt->execute();

        echo "<select id='modelSelect' class='form-select' name='modelSelect' onchange='hardware_site_option()' required>";
        echo "<option value='' selected></option>";
        while ($row4 = $stmt->fetch()){
            echo "<option value='".$row4[2]."' onchange=''>".$row4[2]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}
?>