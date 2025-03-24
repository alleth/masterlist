<?php
include "BaseDAO.php";

class viewRegionServerDAO extends BaseDAO {
    function viewRegionSever(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_server' class='form-select' name='server_region_name' onchange='server_site_option()' required>";
        echo "<option value='' selected disabled>Select Region</option>";
        echo "<option value='all'>All Region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."' onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}