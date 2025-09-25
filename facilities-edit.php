<?php
require_once "DAO/facilities-editDAO.php";

if (isset($_POST['site_id'])) {
    $site_id = $_POST['site_id'];
    $dao = new FacilitiesEditDAO();
    $siteData = $dao->getSiteById($site_id);

    if ($siteData) {
        echo json_encode(["success" => true, "site" => $siteData]);
    } else {
        echo json_encode(["success" => false, "message" => "Site not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
