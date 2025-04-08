<?php

include "DAO/hardware-model-DAO.php";

$model_item_name = $_POST["model_item_name"];

$action = new hardwareModelDAO();
$action->hardwareModel($model_item_name);
