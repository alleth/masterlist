<?php
include "BaseDAO.php";
class viewModelOptionDAO extends BaseDAO {
    function viewModelOption(){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_model_tbl WHERE hw_brand_id = '1'");
        $stmt->execute();

        echo "<option value='' selected disabled>Select Model Name</option>";
        while ($row = $stmt->fetch()){
            echo "<option onclick='brand_name_option(".$row[0].")'>$row[1]</option>";
        }
        $this->closeConn();
    }
}