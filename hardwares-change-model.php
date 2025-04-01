<?php

    include "DAO/hardwares-change-model-DAO.php";

    $hw_id = $_POST["hw_id"];
    $brand_name = $_POST["brand_name"];

    $action = new changeModelDAO();
    $action->changeModel($hw_id, $brand_name);
