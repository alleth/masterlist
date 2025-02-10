<?php
include "DAO/model-edit-modal-DAO.php";
$brand_name = $_POST["brand_nameEdit"];
$hw_type = "CPU-PC";
$action = new modelEditDAO();
$action->modelEdit($brand_name, $hw_type);
