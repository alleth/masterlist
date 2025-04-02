<?php
    include "BaseDAO.php";
    class hardwareSelectSiteDAO extends BaseDAO{
        function hardwaresSelectSite($site_name){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ? ORDER BY site_code");
            $stmt->bindParam(1, $site_name);
            $stmt->execute();

            while ($row5 = $stmt->fetch()){
                echo "<option value='$row5[1]'>$row5[1] &ndash; $row5[2]</option>";
            }
        }
    }