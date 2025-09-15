<?php
require_once "DAO/Dashboardv3-site-dataDAO.php";

$region = $_GET['region'] ?? '';
$site   = $_GET['site'] ?? '';

header('Content-Type: application/json');

try {
    $dao = new SiteCountDAO();
    $result = $dao->getSiteCount($region, $site);
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode([ "error" => $e->getMessage() ]);
}
