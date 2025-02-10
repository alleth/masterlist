<?php
include "BaseDAO.php";
class modelEditDAO extends BaseDAO {
    function modelEdit($brand_name, $hw_type){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_brand_name = ? AND hw_type = ?");
        $stmt->bindParam(1, $brand_name);
        $stmt->bindParam(2, $hw_type);
        $stmt->execute();

        while ($row = $stmt->fetch()){
            $hw_id = $row[0];
        }

        $hw_model = $this->dbh->prepare("SELECT * FROM hw_model_tbl WHERE hw_brand_id = ?");
        $hw_model->bindParam(1, $hw_id);
        $hw_model->execute();

        echo "<option value='' selected disabled>Select hardware model</option>";
        while ($model_row = $hw_model->fetch()){
            echo "<option value='".$model_row[1]."'>$model_row[1]</option>";
        }
        $this->closeConn();

    }
}