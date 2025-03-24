<?php
include "DAO/directory-specific-region-DAO.php";

$region_name = $_POST["region_name"];

$action = new viewDirectorySpecificRegionDAO();
$action->viewDirectorySpecificRegion($region_name);