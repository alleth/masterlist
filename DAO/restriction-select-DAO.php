<?php
include "BaseDAO.php";
class restrictSelectDAO extends BaseDAO {
    function restrictSelect ($user_type, $region_assigned){
        $this->openConn();

        if ($user_type == "ADM" || $user_type == "SPV"){
            echo "<label class='visually-hidden' for='specificSizeSelect'>Select Region</label>";
            echo "<select class='form-select' id='specificSizeSelect' onchange='sortHardware()'>";
            echo "<option selected disabled>Select a region</option>";
            echo "<option value='all'>All</option>";

            $region_fetch = $this->dbh->prepare("SELECT * FROM region_tbl");
            $region_fetch->execute();

            while ($region_row = $region_fetch->fetch()){
                echo "<option value='$region_row[0]'>$region_row[1]</option>";
            }
            echo "</select>";




        }else{

            $region_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ?");
            $region_name->bindParam(1,$region_assigned);
            $region_name->execute();

            echo "<label class='visually-hidden' for='specificSizeSelect'>Select Region</label>";
            echo "<select class='form-select' id='specificSizeSelect' onchange='sortHardware()'>";
            echo "<option selected disabled>Select a site</option>";

            while ($row = $region_name->fetch()){
                echo "<option value='$row[1]'>$row[1] &ndash; $row[2]</option>";
            }

            echo "</select>";
            $this->closeConn();

        }
    }
}