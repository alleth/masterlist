<?php
include "DAO/facilities-show-DAO.php";

$region = isset($_POST['region']) ? $_POST['region'] : 'all';

$dao = new FacilitiesShowDAO();
$htmlRows = $dao->getFacilitiesByRegion($region);

echo $htmlRows;
