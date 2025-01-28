<?php

include "DAO/cpu-edit-details-DAO.php";
include "auth.php";

$hw_id = $_POST["hw_id"];
$brand_name = $_POST["brand_name"];
$model_name = $_POST["model_name"];
$asset_num = $_POST["asset_num"];
$serial_num = $_POST["serial_num"];
$date_acquired = $_POST["date_acquired"];
$hw_status = $_POST["hw_status"];
$host_name = $_POST["host_name"];
$ip_add = $_POST["ip_add"];
$mac_add = $_POST["mac_add"];
$hw_user = $_POST["hw_user"];
$primary_role = $_POST["primary_role"];
$user_id = $_SESSION['sess_id'];

$action = new cpuEditDetailsDAO();
$action->cpuEditDetails($hw_id,
                        $brand_name,
                        $model_name,
                        $asset_num,
                        $serial_num,
                        $date_acquired,
                        $hw_status,
                        $host_name,
                        $ip_add,
                        $mac_add,
                        $hw_user,
                        $primary_role,
                        $user_id);
