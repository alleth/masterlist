<?php
include "DAO/region-view-DAO.php";
$region_id = $_POST["region_id"];
$action = new viewRegionSelectDAO();
$action->viewRegionSelect($region_id);