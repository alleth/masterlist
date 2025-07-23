<?php
include "BaseDAO.php";

class regionRegionHWDAO extends BaseDAO {
    function loadRegionOptions(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        while ($row = $stmt->fetch()){
            echo "<option value='$row[0]'>$row[1]</option>";
        }

        $this->closeConn();
    }
}
