<?php

include "BaseDAO.php";
class saveSiteDetailsDAO extends BaseDAO{
    function saveSiteDetails($site_id, $region_name, $site_code, $site_name, $office_type, $site_address, $site_partnership){
        $this->openConn();
        $stmt = $this->dbh->prepare("UPDATE site_list_tbl SET site_code = ?, site_name = ?, site_address = ?, region_id = ?, office_type = ?, site_partnership = ? WHERE site_id = ?");
        $stmt->bindParam(1, $site_code);
        $stmt->bindParam(2, $site_name);
        $stmt->bindParam(3, $site_address);
        $stmt->bindParam(4, $region_name);
        $stmt->bindParam(5, $office_type);
        $stmt->bindParam(6, $site_partnership);
        $stmt->bindParam(7, $site_id);
        $stmt->execute();

        $region_request = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
        $region_request->bindParam(1,$region_name);
        $region_request->execute();

        while ($region_row = $region_request->fetch()){
            $region_value = $region_row[1];
        }

        echo "<td>" . (!empty($region_value) ? $region_value : "Unidentified") . "</td>";
        echo "<td>" . (!empty($office_type) ? $office_type : "Unidentified") . "</td>";
        echo "<td>" . (!empty($site_code) ? $site_code : "Unidentified") . "</td>";
        echo "<td>" . (!empty($site_name) ? $site_name : "Unidentified") . "</td>";
        echo "<td>" . (!empty($site_address) ? $site_address : "Unidentified") . "</td>";
        echo "<td>" . (!empty($site_partnership) ? $site_partnership : "Unidentified") . "</td>";
        echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='siteFunction(".$site_id.")'><span class='fas fa-edit'></span></button></td>";

        $this->closeConn();
    }
}