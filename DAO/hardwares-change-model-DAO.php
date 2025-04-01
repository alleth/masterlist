<?php
    include "BaseDAO.php";
    class changeModelDAO extends BaseDAO
    {
        function changeModel($hw_id, $brand_name)
        {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
            $stmt->bindParam(1, $hw_id);
            $stmt->execute();

            while($row = $stmt->fetch()){
                $item_desc = $row[5];
            }

            $get_brand_id = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_brand_name = ? AND hw_type = ?");
            $get_brand_id->bindParam(1, $brand_name);
            $get_brand_id->bindParam(2, $item_desc);
            $get_brand_id->execute();

            while($brand_row = $get_brand_id->fetch()){
                $brand_id = $brand_row[0];
            }

            $get_model = $this->dbh->prepare("SELECT * FROM hw_model_tbl WHERE hw_brand_id = ?");
            $get_model->bindParam(1, $brand_id);
            $get_model->execute();

            $hw_model = [];
            while($model_loop = $get_model->fetch()){
                $hw_model[] = ["model_id" => $model_loop[0], "model_name"=>$model_loop[1]];
            }

            $count = array(
                "hw_model"=>$hw_model,
            );

            $json_string = json_encode($count);
            echo $json_string;
            $this->closeConn();
        }
    }