<?php
include "BaseDAO.php";
class viewRegionHWDAO extends BaseDAO {
    function viewRegionHW(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $assignedRegion = $_SESSION['sess_assigned'] ?? '';

        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_server' class='form-select' name='hw_region_name' onchange='hardware_site_option()' required>";
        echo "<option value='all_region'>All region</option>";
        while ($row = $stmt->fetch()){
            $selected = ($assignedRegion !== '' && $row[0] == $assignedRegion) ? " selected" : "";
            echo "<option value='".$row[0]."'".$selected." onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}