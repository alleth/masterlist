<?php
include "BaseDAO.php";
class viewBrandOptionDAO extends BaseDAO {
    function viewBrandOption($hw_type){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_type = ?");
        $stmt->bindParam(1, $hw_type);
        $stmt->execute();

        echo "<select class='form-select' name='brand_name' onchange='brandName()' required>";
        echo "<option value='' selected disabled>Select Brand Name</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[0]."'>$row[1]</option>";
        }
        echo "</select>";
        $this->closeConn();
    }
}