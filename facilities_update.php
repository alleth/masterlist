<?php
require_once "DAO/facilities-updateDAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_id = $_POST['site_id'] ?? null;

    $data = [
        'node_count' => $_POST['node_count'] ?? 0,
        'node_working' => $_POST['node_working'] ?? 0,
        'node_defective' => $_POST['node_defective'] ?? 0,
        'node_available' => $_POST['node_available'] ?? 0,
        'outlet_count' => $_POST['outlet_count'] ?? 0,
        'outlet_working' => $_POST['outlet_working'] ?? 0,
        'outlet_defective' => $_POST['outlet_defective'] ?? 0,
        'outlet_available' => $_POST['outlet_available'] ?? 0,
        'port_count' => $_POST['port_count'] ?? 0,
        'port_working' => $_POST['port_working'] ?? 0,
        'port_defective' => $_POST['port_defective'] ?? 0,
        'port_available' => $_POST['port_available'] ?? 0,
        'type_electrical_con' => $_POST['type_electrical_con'] ?? ""
    ];

    $dao = new FacilitiesUpdateDAO();
    $success = $dao->updateFacilities($site_id, $data);

    echo json_encode([
        "success" => $success,
        "message" => $success ? "Update successful" : "Update failed"
    ]);
}
