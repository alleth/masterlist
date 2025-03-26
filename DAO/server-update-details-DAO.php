<?php
    include "BaseDAO.php";

    class serverUpdateDetailsDAO extends BaseDAO {
        function serverUpdateDetails($server_id){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
            $stmt->bindParam(1, $server_id);
            $stmt->execute();

            $record = $stmt->fetch();

            $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
            $site_name->bindParam(1, $record[2]);
            $site_name->execute();

            while ($site_row = $site_name->fetch()){
                $get_site_name = $site_row[2];
            }

            $count = array("server_id"=>$record[0], "region_id"=>$record[1], "site_code"=>$record[2], "site_name"=>$get_site_name, "brand_name"=>$record[6]);
            $json_string = json_encode($count);
            echo $json_string;
            $this->closeConn();
        }
    }