<?php
include "BaseDAO.php";
class viewRegionHWDAO extends BaseDAO {
    function viewRegionHW(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_server' class='form-select' name='hw_region_name' onchange='hardware_site_option()' required>";
        echo "<option value='all_region'>All region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."' onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}