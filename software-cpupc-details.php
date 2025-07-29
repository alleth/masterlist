<?php
include "DAO/software-cpupc-details-DAO.php";

$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : null;
$site_code = isset($_POST['site_code']) ? $_POST['site_code'] : null;

$dao = new CpuPcDetailsDAO();
$dao->getCpuPcDetails($region_id, $site_code);


