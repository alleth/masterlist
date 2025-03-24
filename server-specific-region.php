<?php
include "DAO/server-specific-region-DAO.php";

$region_name = $_POST["region_name"];

$action = new viewServerSpecificRegionDAO();
$action->viewServerSpecificRegion($region_name);