<?php
include "BaseDAO.php";

class regionRegionHWDAO extends BaseDAO {
    function regionRegionHW(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='RegionSelect' class='form-select addHardwareForm' name='RegionSelect' onchange='hardware_site_select()'>";
        echo "<option value='' disabled selected>Select region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='$row[0]'>$row[1]</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}