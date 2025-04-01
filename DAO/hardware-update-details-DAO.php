<?php
    include "BaseDAO.php";
    class updateDetailsDAO extends BaseDAO
    {
        function updateDetails($hw_id)
        {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
            $stmt->bindParam(1, $hw_id);
            $stmt->execute();

            $record = $stmt->fetch();

            $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_name->bindParam(1, $record[1]);
            $region_name->execute();

            while ($region_row = $region_name->fetch()){
                $get_region_name = $region_row[1];
            }

            $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
            $site_name->bindParam(1, $record[2]);
            $site_name->execute();

            while ($site_row = $site_name->fetch()){
                $get_site_name = $site_row[2];
            }

            $brand_stmt = $this->dbh->prepare("SELECT * FROM hw_brand_tbl WHERE hw_type = ?");
            $brand_stmt->bindParam(1, $record[4]);
            $brand_stmt->execute();

            $brands = [];
            while ($brand_row = $brand_stmt->fetch()) {
                $brands[] = $brand_row[1];

            }

            $model_id_stmt = $this->dbh->prepare("SELECT hw_brand_id FROM hw_brand_tbl WHERE hw_brand_name = ? AND hw_type = ?");
            $model_id_stmt->bindParam(1, $record[6]);
            $model_id_stmt->bindParam(2, $record[4]);
            $model_id_stmt->execute();

            $model_row = $model_id_stmt->fetch();

            $model_stmt = $this->dbh->prepare("SELECT * FROM hw_model_tbl WHERE hw_brand_id = ?");
            $model_stmt->bindParam(1, $model_row['hw_brand_id']);
            $model_stmt->execute();


            $hw_model = [];
            while($model_loop = $model_stmt->fetch()){
                $hw_model[] = ["model_id" => $model_loop[0], "model_name"=>$model_loop[1]];
            }


            $count = array(
                "hw_id"=>$record[0],
                "region_name"=>$get_region_name,
                "site_code"=>$record[2],
                "site_name"=>$get_site_name,
                "brands"=>$brands,
                "selected_brand"=>$record[6],
                "hw_model"=>$hw_model,
                "selected_model"=>$record[7],
                "acq_val"=>$record[11],
                "asset_num"=>$record[8],
                "serial_num"=>$record[9],
                "date_acq"=>$record[10],
                "hw_status"=>$record[12]
            );

            $json_string = json_encode($count);
            echo $json_string;
            $this->closeConn();
        }
    }