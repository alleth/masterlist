<?php
include "BaseDAO.php";
class viewBrandOptionDAO extends BaseDAO {
    function viewBrandOption(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_type = 'CPU-PC'");
        $stmt->execute();

        echo "<option value='' selected disabled>Select Brand Name</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='$row[1]'>$row[1]</option>";
        }
        $this->closeConn();
    }
}