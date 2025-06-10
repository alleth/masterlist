<?php
// Disable error display
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Log errors
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

ob_start();
header('Content-Type: application/json');

try {
    // Define file paths using absolute paths
    $hardwareDAOPath = 'DAO\HardwareDAO.php';
    $baseDAOPath = 'DAO\BaseDAO.php';

    // Check file existence with detailed logging
    $missingFiles = [];
    if (!file_exists($hardwareDAOPath)) {
        $missingFiles[] = $hardwareDAOPath;
    }
    if (!file_exists($baseDAOPath)) {
        $missingFiles[] = $baseDAOPath;
    }

    if (!empty($missingFiles)) {
        error_log('Missing required files: ' . implode(', ', $missingFiles));
        echo json_encode(['error' => 'Server configuration error: Missing files - ' . implode(', ', $missingFiles)]);
        exit;
    }

    require_once $hardwareDAOPath;
    require_once $baseDAOPath;

    $action = $_GET['action'] ?? '';
    error_log("API request: action=$action, params=" . json_encode($_GET));

    $dao = new HardwareDAO();

    if ($action === 'getHardwareCounts') {
        $params = [];
        if (isset($_GET['region_id']) && $_GET['region_id'] !== '') {
            $params['region_id'] = $_GET['region_id'];
        }
        if (isset($_GET['site_code']) && $_GET['site_code'] !== '' && $_GET['site_code'] !== '0') {
            $params['site_code'] = $_GET['site_code'];
        }
        error_log("getHardwareCounts params: " . json_encode($params));
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
        error_log("getSiteCounts params: " . json_encode($params));
        $result = $dao->getSiteCounts($params);
        echo json_encode($result);
    } else {
        error_log("Invalid action: $action");
        echo json_encode(['error' => 'Invalid action']);
    }
} catch (Exception $e) {
    error_log("API error: " . $e->getMessage());
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

ob_end_flush();