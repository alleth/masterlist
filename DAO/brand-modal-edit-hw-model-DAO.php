<?php
include "BaseDAO.php";
class brandModalEditDAO extends BaseDAO {
    function brandModalEdit($hw_type){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_type = ?");
        $stmt->bindParam(1, $hw_type);
        $stmt->execute();

        echo "<option value='' selected disabled>Select Brand Name</option>";
        while ($row = $stmt->fetch()){
            echo "<option value='".$row[1]."'>$row[1]</option>";
        }
        $this->closeConn();
    }
}