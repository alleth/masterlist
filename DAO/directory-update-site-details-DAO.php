<?php
 include "BaseDAO.php";
 class updateSiteDetailsDAO extends BaseDAO{
     function updateSiteDetails($site_id){
         $this->openConn();
         $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_id = ?");
         $stmt->bindParam(1, $site_id);
         $stmt->execute();

         $record = $stmt->fetch();


         $count = array("site_id"=>$record[0], "region_name"=>$record[4], "site_code"=>$record[1], "site_name"=>$record[2], "office_type"=>$record[5], "site_address"=>$record[3], "partnership"=>$record[6]);
         $json_string = json_encode($count);
         echo $json_string;

         $this->closeConn();
     }
 }