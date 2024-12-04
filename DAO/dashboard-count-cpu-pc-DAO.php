<?php
include "BaseDAO.php";
class countCPUPCDAO extends BaseDAO {
    function countCPUPC(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl");
        $stmt->execute();

        $count = 0;

        while($row = $stmt->fetch()){
            $count++;
        }
        echo $count;
    }
}