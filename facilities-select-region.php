<?php
require_once 'DAO/facilities-select-regionDAO.php';


header("Content-Type: application/json");

$regionDAO = new RegionDAO();
$regions = $regionDAO->getAllRegions();

echo json_encode($regions);
