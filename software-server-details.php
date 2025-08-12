<?php
include "DAO/software-server-details-DAO.php";

$region_id = isset($_POST['region_id']) ? $_POST['region_id'] : null;

$dao = new CpuPcDetailsDAO();
$dao->getCpuPcDetails($region_id);


