<?php
include "BaseDAO.php";
class viewSiteCodeDAO extends BaseDAO {
    function viewSiteCode($site_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_id = ?");
        $stmt->bindParam(1,$site_id);
        $stmt->execute();

        while ($row = $stmt->fetch()){
            echo $row[1];
        }
        $this->closeConn();
    }
}