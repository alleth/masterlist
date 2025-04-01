<?php

include "BaseDAO.php";
class saveHardwaresDetailsDAO extends BaseDAO{
    function saveHardwaresDetails($hw_id, $brand_name, $model_name, $acquired_value, $asset_num, $serial_num, $date_acquired){
        $this->openConn();
        $stmt = $this->dbh->prepare("UPDATE hw_tbl SET hw_brand_name = ?, hw_model = ?, hw_acq_val = ?, hw_asset_num = ?, hw_serial_num = ?, hw_date_acq = ? WHERE hw_id = ?");
        $stmt->bindParam(1, $brand_name);
        $stmt->bindParam(2, $model_name);
        $stmt->bindParam(3, $acquired_value);
        $stmt->bindParam(4, $asset_num);
        $stmt->bindParam(5, $serial_num);
        $stmt->bindParam(6, $date_acquired);
        $stmt->bindParam(7, $hw_id);
        $stmt->execute();

        $region_request = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $region_request->bindParam(1,$hw_id);
        $region_request->execute();

        while ($region_row = $region_request->fetch()){
            $region_id = $region_row[1];
            $site_code_request = $region_row[2];
            $item_desc = $region_row[5];
        }

        $show_region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
        $show_region_name->bindParam(1, $region_id);
        $show_region_name->execute();

        while($show_region_row = $show_region_name->fetch()){
            $region_value = $show_region_row[1];
        }

        $show_site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
        $show_site_name->bindParam(1, $site_code_request);
        $show_site_name->execute();

        while ($show_site_row = $show_site_name->fetch()){
            $site_code = $show_site_row[1];
            $site_name = $show_site_row[2];
        }

        echo "<td>" . (!empty($region_value) ? $region_value : "Unidentified") . "</td>";
        echo "<td>$site_code &ndash; $site_name</td>";
        echo "<td>$item_desc</td>";
        echo "<td>" . (!empty($brand_name) ? $brand_name : "Unidentified") . "</td>";
        echo "<td>" . (!empty($model_name) ? $model_name : "Unidentified") . "</td>";
        echo "<td>" . (!empty($asset_num) ? $asset_num : "Unidentified") . "</td>";
        echo "<td>" . (!empty($serial_num) ? $serial_num : "Unidentified") . "</td>";
        echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='hardwareUpdate(".$hw_id.")'><span class='fas fa-edit'></span></button></td>";

        $this->closeConn();
    }
}