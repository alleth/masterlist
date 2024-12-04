<?php
include "BaseDAO.php";
class countServerDAO extends BaseDAO {
    function countServer(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM srvr_tbl");
        $stmt->execute();

        $count = 0;

        while($row = $stmt->fetch()){
            $count++;
        }
        echo $count;
    }
}