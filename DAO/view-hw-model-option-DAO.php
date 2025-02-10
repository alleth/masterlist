<?php
include "BaseDAO.php";
class viewModelOptionDAO extends BaseDAO {
    function viewModelOption($brand_name){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_model_tbl WHERE hw_brand_id = ?");
        $stmt->bindParam(1, $brand_name);
        $stmt->execute();

        while ($row = $stmt->fetch()){
            echo "<option onclick='brand_name_option(".$row[0].")'>$row[1]</option>";
        }
        $this->closeConn();
    }
}