<?php
include "BaseDAO.php";
class restrictSelectDAO extends BaseDAO {
    function restrictSelect ($user_type, $region_assigned){

        if ($user_type == "ADM" || $user_type == "SPV"){
            echo "<label class='visually-hidden' for='specificSizeSelect'>Select Region</label>
                            <select class='form-select' id='specificSizeSelect' onchange='sortHardware()'>
                                <option selected disabled>Select a region</option>
                                <option value='all'>All</option>
                                <option value='NCR'>NCR</option>
                                <option value='Region 2'>Region 2</option>
                                <option value='Region 3'>Region 3</option>
                                <option value='Region 4-A'>Region 4-A</option>
                                <option value='Region 4-B'>Region 4-B</option>
                                <option value='Region 5'>Region 5</option>
                                <option value='Region 6'>Region 6</option>
                                <option value='Region 7'>Region 7</option>
                                <option value='Region 8'>Region 8</option>
                                <option value='Region 9'>Region 9</option>
                                <option value='Region 10'>Region 10</option>
                                <option value='Region 11'>Region 11</option>
                                <option value='Region 12'>Region 12</option>
                                <option value='BARMM'>BARMM</option>
                                <option value='CAR'>CAR</option>
                            </select>";
        }else{

            $this->openConn();
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