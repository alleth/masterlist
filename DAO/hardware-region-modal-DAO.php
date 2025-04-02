<?php
include "BaseDAO.php";

class regionRegionHWDAO extends BaseDAO {
    function regionRegionHW(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='RegionSelect' class='form-select' name='RegionSelect' onchange='hardware_site_select()' required>";
        echo "<option value='' selected></option>";
        while ($row2 = $stmt->fetch()){
            echo "<option value='".$row2[0]."' onchange=''>".$row2[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}