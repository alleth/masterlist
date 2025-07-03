<?php
include "BaseDAO.php";

class viewModalRegionDAO extends BaseDAO {
    function viewModalRegion(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_modal' class='form-select' name='region_modal' onchange='' required>";
        echo "<option value='' selected disabled>Select Region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."' onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}