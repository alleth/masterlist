<?php

include "DAO/add-cpu-pc-DAO.php";
$region_name = $_POST["region_name"];
$site_name = $_POST["site_name"];
$brand_name = $_POST["brand_name"];
$model_name = $_POST["model_name"];
$asset_num = $_POST["asset_num"];
$serial_num = $_POST["serial_num"];
$date_acquired = $_POST["date_acquired"];
$status_option = $_POST["status_option"];
$host_name = $_POST["host_name"];
$ip_address = $_POST["ip_address"];
$mac_address = $_POST["mac_address"];
$user_name = $_POST["user_name"];
$primary_role = $_POST["primary_role"];
$acquired_value = $_POST["acquired_value"];

$action = new addCPUDataDAO();
$action->addCPUData($region_name, $site_name, $brand_name, $model_name, $asset_num, $serial_num, $date_acquired, $status_option, $host_name, $ip_address, $mac_address, $user_name, $primary_role, $acquired_value);