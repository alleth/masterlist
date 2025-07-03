<?php
include "BaseDAO.php";

class changeModelDAO extends BaseDAO
{
    function changeModel($hw_id, $brand_name)
    {
        try {
            $this->openConn();

            // Fetch item type from hw_id_tbl (assuming hw_id links to hw_model_id)
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_id = ?");
            $stmt->bindParam(1, $hw_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->closeConn();
                echo json_encode(["hw_model" => [], "error" => "Hardware ID not found"]);
                return;
            }
            $item_type = $row['item_desc'];

            // Fetch brand ID from hw_brand_tbl
            $get_brand_id = $this->dbh->prepare("SELECT * FROM item_brand WHERE brand = ? AND item_desc = ?");
            $get_brand_id->bindParam(1, $brand_name);
            $get_brand_id->bindParam(2, $item_type);
            $get_brand_id->execute();
            $brand_row = $get_brand_id->fetch(PDO::FETCH_ASSOC);

            if (!$brand_row) {
                $this->closeConn();
                echo json_encode(["hw_model" => [], "error" => "Brand not found for the given hardware type"]);
                return;
            }

            $brand = $brand_row['brand'];
            $item_name = $brand_row['item_desc'];

            // Fetch models from item_models
            $get_hw_id = $this->dbh->prepare("SELECT * FROM item_models WHERE brand = ? AND item_desc = ?");
            $get_hw_id->bindParam(1, $brand);
            $get_hw_id->bindParam(2, $item_name);
            $get_hw_id->execute();

            $hw_data = [];
            while ($hw_loop = $get_hw_id->fetch(PDO::FETCH_ASSOC)) {
                $hw_data[] = ["hw_id" => $hw_loop['id'], "model_name" => $hw_loop['model']];
            }

            // Check if no models were found
            if (empty($hw_data)) {
                $this->closeConn();
                echo json_encode(["hw_model" => [], "error" => "No models found for the given brand and hardware type"]);
                return;
            }

            $this->closeConn();
            echo json_encode(["hw_model" => $hw_data]);
        } catch (PDOException $e) {
            $this->closeConn();
            echo json_encode(["hw_model" => [], "error" => "Database error: " . $e->getMessage()]);
        }
    }
}
?>