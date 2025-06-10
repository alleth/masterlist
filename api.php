<?php
// api.php

// Disable error display
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Disable error logging
ini_set('log_errors', 0);

ob_start();
header('Content-Type: application/json');

try {
    // Define file paths using absolute paths
    $hardwareDAOPath = 'DAO\HardwareDAO.php';
    $baseDAOPath = 'DAO\BaseDAO.php';

    // Check file existence
    $missingFiles = [];
    if (!file_exists($hardwareDAOPath)) {
        $missingFiles[] = $hardwareDAOPath;
    }
    if (!file_exists($baseDAOPath)) {
        $missingFiles[] = $baseDAOPath;
    }

    if (!empty($missingFiles)) {
        echo json_encode(['error' => 'Server configuration error: Missing files - ' . implode(', ', $missingFiles)]);
        exit;
    }

    require_once $hardwareDAOPath;
    require_once $baseDAOPath;

    $action = $_GET['action'] ?? '';

    $dao = new HardwareDAO();

    if ($action === 'getHardwareCounts') {
        $params = [];
        if (isset($_GET['region_id']) && $_GET['region_id'] !== '') {
            $params['region_id'] = $_GET['region_id'];
        }
        if (isset($_GET['site_code']) && $_GET['site_code'] !== '' && $_GET['site_code'] !== '0') {
            $params['site_code'] = $_GET['site_code'];
        }
        $result = $dao->getHardwareCounts($params);
        echo json_encode($result);
    } elseif ($action === 'getRegions') {
        $result = $dao->getRegions();
        echo json_encode($result);
    } elseif ($action === 'getSites') {
        $region_id = $_GET['region_id'] ?? '';
        $result = $dao->getSites($region_id);
        echo json_encode($result);
    } elseif ($action === 'getSiteCounts') {
        $params = [];
        if (isset($_GET['region_id']) && $_GET['region_id'] !== '') {
            $params['region_id'] = $_GET['region_id'];
        }
        if (isset($_GET['site_code']) && $_GET['site_code'] !== '' && $_GET['site_code'] !== '0') {
            $params['site_code'] = $_GET['site_code'];
        }
        $result = $dao->getSiteCounts($params);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

ob_end_flush();