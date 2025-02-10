<?php
include "BaseDAO.php";
class brandModalEditDAO extends BaseDAO {
    function brandModalEdit($hw_type){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_type = ?");
        $stmt->bindParam(1, $hw_type);
        $stmt->execute();

        echo "<dd class='col-sm-12'>";
            echo "<div class='sr-only'>Brand</div>";
                echo "<select class='form-select' name='brand_nameEdit' required>";
                    echo "<option value='' selected disabled>Select Brand Name</option>";
                    while ($row = $stmt->fetch()){
                        $hw_brand_id = $row[0];
                        echo "<option value='".$row[1]."'>$row[1]</option>";
                    }
                echo "</select>";
        echo "</dd>";

        echo "<dd class='col-sm-12'>";
            echo "<div class='sr-only'>Model</div>";

            echo "<select class='form-select' name='model_nameEdit'>";
            echo "<option value='' selected disabled>Select hardware model</option>";

                $hw_model = $this->dbh->prepare("SELECT * FROM hw_model_tbl WHERE hw_brand_id = ?");
                $hw_model->bindParam(1, $hw_brand_id);
                $hw_model->execute();

                while ($model_row = $hw_model->fetch()){
                    echo "<option value='".$model_row[1]."'>$model_row[1]</option>";
                }

            echo "</select>";
        echo "</dd>";
        $this->closeConn();
    }
}