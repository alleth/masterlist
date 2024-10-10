<?php
include "BaseDAO.php";
class viewSiteListDAO extends BaseDAO {
    function viewSiteList($region_id){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ?");
        $stmt->bindParam(1,$region_id);
        $stmt->execute();

        while ($row = $stmt->fetch()){
            echo "<option onclick='site_name_option(".$row[0].")'>$row[2]</option>";
        }
        $this->closeConn();
    }
}