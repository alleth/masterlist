<?php
include "BaseDAO.php";

class viewRegionServerDAO extends BaseDAO {
    function viewRegionSever(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_server_modal' class='form-select' name='server_region_name_modal' onchange='server_site_option()' required>";
        echo "<option value='' selected disabled>Select Region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."' onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}