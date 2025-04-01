<?php
    include "DAO/hardwares-save-details-DAO.php";

    $hw_id = $_POST["hw_id"];
    $brand_name = $_POST["brand_name"];
    $model_name = $_POST["model_name"];
    $acquired_value = $_POST["acquired_value"];
    $asset_num = $_POST["asset_num"];
    $serial_num = $_POST["serial_num"];
    $date_acquired = $_POST["date_acquired"];

    $action = new saveHardwaresDetailsDAO();
    $action->saveHardwaresDetails($hw_id, $brand_name, $model_name, $acquired_value, $asset_num, $serial_num, $date_acquired);