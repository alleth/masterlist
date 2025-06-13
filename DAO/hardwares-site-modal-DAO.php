<?php
    include "BaseDAO.php";
    class hardwareSelectSiteDAO extends BaseDAO{
        function hardwaresSelectSite($region_name){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ? ORDER BY site_code");
            $stmt->bindParam(1, $region_name);
            $stmt->execute();

            while ($row = $stmt->fetch()){
                echo "<option value='$row[1]'>$row[1] &ndash; $row[2]</option>";
            }

            $this->closeConn();
        }
    }