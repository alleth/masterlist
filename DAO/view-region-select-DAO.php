<?php
include "BaseDAO.php";
class viewRegionSelectDAO extends BaseDAO {
    function viewRegionSelect(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<option>Select Region</option>";
        while ($row = $stmt->fetch()){
            echo "<option onclick='region_option($row[0])'>$row[1]</option>";
        }
        $this->closeConn();
    }
}