<?php
include 'DAO/server-config-DAO.php';

header('Content-Type: application/json');

// Suppress PHP errors to prevent HTML output
error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $dao = new ServerConfigDAO();

    switch ($_POST['action']) {
        case 'getRegions':
            echo json_encode($dao->getRegions());
            break;

        case 'getSitesByRegion':
            if (isset($_POST['region_id'])) {
                echo json_encode($dao->getSitesByRegion($_POST['region_id']));
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing region_id parameter'
                ]);
            }
            break;

        case 'getHardware':
            if (isset($_POST['region_id']) && isset($_POST['site_code'])) {
                echo json_encode($dao->getHardwareByRegionAndSite($_POST['region_id'], $_POST['site_code']));
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing parameters'
                ]);
            }
            break;

        case 'updateHardware':
            if (isset($_POST['hw_asset_num'], $_POST['hw_serial_num'], $_POST['site_code'], $_POST['region_id'])) {
                echo json_encode($dao->updateHardware(
                    $_POST['hw_asset_num'],
                    $_POST['hw_serial_num'],
                    $_POST['site_code'],
                    $_POST['region_id'],
                    isset($_POST['hw_host_name']) ? $_POST['hw_host_name'] : null,
                    isset($_POST['hw_mac_add']) ? $_POST['hw_mac_add'] : null,
                    isset($_POST['hw_ip_add']) ? $_POST['hw_ip_add'] : null,
                    isset($_POST['os_type']) ? $_POST['os_type'] : null,
                    isset($_POST['dotnet']) ? $_POST['dotnet'] : null,
                    isset($_POST['hw_memory']) ? $_POST['hw_memory'] : null,
                    isset($_POST['hdd_capacity']) ? $_POST['hdd_capacity'] : null,
                    isset($_POST['hdd_free_space']) ? $_POST['hdd_free_space'] : null
                ));
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing required parameters (hw_asset_num, hw_serial_num, site_code, region_id)'
                ]);
            }
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
            break;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
?>