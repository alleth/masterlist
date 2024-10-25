<?php
include "BaseDAO.php";
class viewRegionSelectDAO extends BaseDAO {
    function viewRegionSelect(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_select' class='form-select' name='region_name' onchange='region_option()' required>";
        echo "<option value='' selected disabled>Select Region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."' onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}