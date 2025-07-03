<?php
include "BaseDAO.php";

class updateDetailsDAO extends BaseDAO
{
    function updateDetails($hw_id)
    {
        $this->openConn();

        // Fetch hardware details
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
        $stmt->bindParam(1, $hw_id);
        $stmt->execute();
        $record = $stmt->fetch();

        if (!$record) {
            echo json_encode(['error' => 'Hardware record not found.']);
            $this->closeConn();
            return;
        }

        // Fetch region name
        $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
        $region_name->bindParam(1, $record[1]);
        $region_name->execute();
        $get_region_name = '';
        while ($region_row = $region_name->fetch()) {
            $get_region_name = $region_row[1];
        }

        // Validate site code
        $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
        $site_name->bindParam(1, $record[2]);
        $site_name->execute();
        $site_row = $site_name->fetch();

        if (!$site_row) {
            echo json_encode(['error' => 'The site code is not available in the directory. Please verify and try again.']);
            $this->closeConn();
            return;
        }
        $get_site_name = $site_row[2];

        // Fetch brands
        $brand_stmt = $this->dbh->prepare("SELECT * FROM item_brand WHERE item_desc = ?");
        $brand_stmt->bindParam(1, $record[5]);
        $brand_stmt->execute();
        $brands = [];
        while ($brand_row = $brand_stmt->fetch()) {
            $brands[] = $brand_row[2];
        }

        // Fetch brand ID
        $model_id_stmt = $this->dbh->prepare("SELECT * FROM item_brand WHERE brand = ? AND item_desc = ?");
        $model_id_stmt->bindParam(1, $record[6]);
        $model_id_stmt->bindParam(2, $record[5]);
        $model_id_stmt->execute();
        $model_row = $model_id_stmt->fetch();

        // Fetch models
        $model_stmt = $this->dbh->prepare("SELECT * FROM item_models WHERE item_desc = ? AND brand = ?");
        $model_stmt->bindParam(1, $model_row['item_desc']);
        $model_stmt->bindParam(2, $model_row['brand']);
        $model_stmt->execute();
        $hw_model = [];
        while ($model_loop = $model_stmt->fetch()) {
            $hw_model[] = ["model_id" => $model_loop[0], "model_name" => $model_loop[3]];
        }

        // Prepare response
        $count = [
            "hw_id" => $record[0],
            "region_name" => $get_region_name,
            "site_code" => $record[2],
            "site_name" => $get_site_name,
            "brands" => $brands,
            "selected_brand" => $record[6],
            "hw_model" => $hw_model,
            "selected_model" => $record[7],
            "acq_val" => $record[11],
            "asset_num" => $record[8],
            "serial_num" => $record[9],
            "date_acq" => $record[10],
            "hw_status" => $record[12]
        ];

        echo json_encode($count);
        $this->closeConn();
    }
}
?>