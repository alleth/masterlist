<?php
include "BaseDAO.php";

class hardwareBrandDAO extends BaseDAO{
    function hardwareBrand($item_name){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_brand WHERE item_desc = ? ORDER BY brand");
        $stmt->bindParam(1, $item_name);
        $stmt->execute();

        while ($row4 = $stmt->fetch()){
            echo "<option value='".$row4[2]."' onchange=''>".$row4[2]."</option>";
        }
    }
}

/*
class hardwareBrandDAO extends BaseDAO {
    function hardwareBrand(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM item_brand");
        $stmt->execute();

        echo "<select id='brandSelect' class='form-select' name='brandSelect' onchange='hardware_site_option()' required>";
        echo "<option value='' selected></option>";
        while ($row4 = $stmt->fetch()){
            echo "<option value='".$row4[2]."' onchange=''>".$row4[2]."</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}


include "BaseDAO.php";
class hardwaresViewSiteDAO extends BaseDAO{
    function hardwaresViewSite($region_name){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ? ORDER BY site_code");
        $stmt->bindParam(1, $region_name);
        $stmt->execute();

        while ($row = $stmt->fetch()){
            echo "<option value='$row[1]'>$row[1] &ndash; $row[2]</option>";
        }
    }
}
*/

?>