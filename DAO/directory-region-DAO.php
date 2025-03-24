<?php
 include "BaseDAO.php";

class viewRegionDirectoryDAO extends BaseDAO {
    function viewRegionDirectory(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM region_tbl");
        $stmt->execute();

        echo "<select id='region_directory' class='form-select' name='region_name' onchange='directory_site_option()' required>";
        echo "<option value='' selected disabled>Select Region</option>";
        echo "<option value='all'>All Region</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."' onchange=''>".$row[1]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}