<?php
include "BaseDAO.php";

class changeModelDAO extends BaseDAO
{
    function changeModel($hw_id, $brand_name)
    {
        try {
            $this->openConn();

            // Fetch item type from hw_id_tbl (assuming hw_id links to hw_model_id)
            $stmt = $this->dbh->prepare("SELECT item_desc FROM hw_tbl WHERE hw_id = ?");
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
            $get_brand_id = $this->dbh->prepare("SELECT hw_brand_id FROM hw_brand_tbl WHERE hw_brand_name = ? AND hw_type = ?");
            $get_brand_id->bindParam(1, $brand_name);
            $get_brand_id->bindParam(2, $item_type);
            $get_brand_id->execute();
            $brand_row = $get_brand_id->fetch(PDO::FETCH_ASSOC);

            if (!$brand_row) {
                $this->closeConn();
                echo json_encode(["hw_model" => [], "error" => "Brand not found for the given hardware type"]);
                return;
            }
            $brand_id = $brand_row['hw_brand_id'];

            // Fetch models from hw_id_tbl
            $get_hw_id = $this->dbh->prepare("SELECT hw_model_id, hw_model_name FROM hw_model_tbl WHERE hw_brand_id = ?");
            $get_hw_id->bindParam(1, $brand_id);
            $get_hw_id->execute();

            $hw_data = [];
            while ($hw_loop = $get_hw_id->fetch(PDO::FETCH_ASSOC)) {
                $hw_data[] = ["hw_id" => $hw_loop['hw_model_id'], "model_name" => $hw_loop['hw_model_name']];
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