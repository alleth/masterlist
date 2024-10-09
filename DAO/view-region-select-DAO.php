<?php
include "BaseDAO.php";
class viewRegionSelectDAO extends BaseDAO {
    function viewRegionSelect(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        while ($row = $stmt->fetch()){
            echo "<option>$row[1]</option>";
        }


        $this->closeConn();

    }
}