<?php
require_once 'DAO/dashboardv3-hardware-dataDAO.php';

$dao = new DashboardDAO();
$data = $dao->getDashboardCounts($_GET['region'] ?? '', $_GET['site'] ?? '');

header('Content-Type: application/json');
echo json_encode($data);
