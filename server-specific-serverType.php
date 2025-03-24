<?php
include "DAO/server-specific-serverType-DAO.php";

$region_name = $_POST["region_name"];
$server_type = $_POST["server_type"];

$action = new viewServerSpecificRegionDAO();
$action->viewServerSpecificRegion($region_name, $server_type);