<?php
include "BaseDAO.php";
class viewRegionSelectDAO extends BaseDAO {
    function viewRegionSelect(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        $numbers = [];
        while($row = $stmt->fetch()){
            $numbers[] = $row;
        }
        $json_string = json_encode($numbers);
        echo $json_string;

        $this->closeConn();
    }
}