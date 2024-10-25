<?php
include "BaseDAO.php";
class viewSiteListDAO extends BaseDAO {
    function viewSiteList($region_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ? ORDER BY site_name");
        $stmt->bindParam(1,$region_id);
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