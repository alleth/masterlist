<?php
include "DAO/request-pullout-DAO.php";
session_start();

$actionType = $_POST['action'] ?? '';

$dao = new requestPulloutDAO();

if ($actionType === 'view_sites') {
    if (isset($_SESSION['sess_assigned'])) {
        $dao->viewSite($_SESSION['sess_assigned']);
    } else {
        echo json_encode(["error" => "Session not set."]);
    }
} elseif ($actionType === 'view_hardware') {
    $hw_type = $_POST["hw_type"] ?? '';
    $site_list = $_POST["site_list"] ?? '';
    $dao->viewHardware($hw_type, $site_list);
}
