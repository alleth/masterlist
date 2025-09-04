<?php
include 'BaseDAO.php';

class SoftwareConfigDAO extends BaseDAO {

    public function getRegions() {
        $retryCount = 0;
        $maxRetries = 2;

        while ($retryCount <= $maxRetries) {
            try {
                $this->openConn();
                $stmt = $this->dbh->prepare("SELECT * FROM region_tbl ORDER BY region_id");
                $stmt->execute();
                $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->closeConn();

                return [
                    'success' => true,
                    'data' => $regions
                ];
            } catch (PDOException $e) {
                $this->closeConn();
                if (strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false && $retryCount < $maxRetries) {
                    $retryCount++;
                    sleep(1); // Wait 1 second before retrying
                    continue;
                }
                return [
                    'success' => false,
                    'message' => strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false
                        ? 'Database is unavailable. Please try again later.'
                        : 'Database error: ' . $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Database is unavailable after multiple attempts.'
        ];
    }

    public function getSitesByRegion($regionId) {
        $retryCount = 0;
        $maxRetries = 2;

        while ($retryCount <= $maxRetries) {
            try {
                $this->openConn();
                $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ? ORDER BY site_code");
                $stmt->execute([$regionId]);
                $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->closeConn();

                return [
                    'success' => true,
                    'data' => $sites
                ];
            } catch (PDOException $e) {
                $this->closeConn();
                if (strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false && $retryCount < $maxRetries) {
                    $retryCount++;
                    sleep(1);
                    continue;
                }
                return [
                    'success' => false,
                    'message' => strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false
                        ? 'Database is unavailable. Please try again later.'
                        : 'Database error: ' . $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Database is unavailable after multiple attempts.'
        ];
    }

    public function getHardwareByRegionAndSite($regionId, $siteCode) {
        $retryCount = 0;
        $maxRetries = 2;

        while ($retryCount <= $maxRetries) {
            try {
                $this->openConn();
                $sql = "SELECT * FROM hw_tbl WHERE item_desc = 'CPU-PC' AND region_name = ? AND site_code = ? AND hw_status = 'On Site'";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute([$regionId, $siteCode]);
                $hardware = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Convert hw_utilities string to array for frontend
                foreach ($hardware as &$hw) {
                    if (!empty($hw['hw_utilities'])) {
                        $hw['utilities'] = explode(',', $hw['hw_utilities']);
                    } else {
                        $hw['utilities'] = [];
                    }
                }

                $this->closeConn();

                return ['success' => true, 'data' => $hardware];
            } catch (PDOException $e) {
                $this->closeConn();
                if (strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false && $retryCount < $maxRetries) {
                    $retryCount++;
                    sleep(1);
                    continue;
                }
                return [
                    'success' => false,
                    'message' => strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false
                        ? 'Database is unavailable. Please try again later.'
                        : 'Database error: ' . $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Database is unavailable after multiple attempts.'
        ];
    }

    public function updateHardware($hw_asset_num, $hw_serial_num, $site_code, $region_id, $hw_host_name, $hw_mac_add, $hw_ip_add, $os_type, $dotnet, $hw_primary_role, $hw_memory, $hdd_capacity, $hdd_free_space, $utilities) {
        $retryCount = 0;
        $maxRetries = 2;

        while ($retryCount <= $maxRetries) {
            try {
                $this->openConn();

                // Validate MAC address (12 hexadecimal chars)
                if (!empty($hw_mac_add) && !preg_match('/^[0-9A-Fa-f]{12}$/', str_replace('-', '', $hw_mac_add))) {
                    $this->closeConn();
                    return ['success' => false, 'message' => 'Invalid MAC Address'];
                }

                // Validate IP address (four octets, 0-255)
                if (!empty($hw_ip_add) && $hw_ip_add !== '0.0.0.0') {
                    $ipParts = explode('.', $hw_ip_add);
                    if (count($ipParts) !== 4 || !array_reduce($ipParts, function($carry, $part) {
                            return $carry && is_numeric($part) && $part >= 0 && $part <= 255 && preg_match('/^\d{1,3}$/', $part);
                        }, true)) {
                        $this->closeConn();
                        return ['success' => false, 'message' => 'Invalid IP Address'];
                    }
                }

                // Validate utilities for Approving workstep
                if ($hw_primary_role === 'Approving' && (empty($utilities) || !is_array($utilities))) {
                    $this->closeConn();
                    return ['success' => false, 'message' => 'Utilities required for Approving workstep'];
                }

                // Validate Approving workstep uniqueness per site_code
                if ($hw_primary_role === 'Approving') {
                    $stmt = $this->dbh->prepare("SELECT site_code FROM hw_tbl WHERE hw_asset_num = ?");
                    $stmt->execute([$hw_asset_num]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $db_site_code = $result['site_code'];

                    if ($db_site_code !== $site_code) {
                        $this->closeConn();
                        return ['success' => false, 'message' => 'Site code mismatch for hardware'];
                    }

                    $stmt = $this->dbh->prepare("SELECT hw_asset_num FROM hw_tbl WHERE site_code = ? AND hw_primary_role = 'Approving' AND hw_asset_num != ?");
                    $stmt->execute([$site_code, $hw_asset_num]);
                    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                        $this->closeConn();
                        return ['success' => false, 'message' => 'Approving workstep already assigned for this site'];
                    }
                }

                // Convert utilities array to comma-separated string
                $utilities_str = is_array($utilities) ? implode(',', $utilities) : '';

                // Update hardware record, excluding users
                $sql = "UPDATE hw_tbl SET 
                        hw_host_name = ?, 
                        hw_mac_add = ?, 
                        hw_ip_add = ?, 
                        os_type = ?, 
                        dotnet = ?, 
                        hw_primary_role = ?, 
                        hw_memory = ?, 
                        hdd_capacity = ?, 
                        hdd_free_space = ?, 
                        hw_utilities = ?
                        WHERE hw_asset_num = ? AND hw_serial_num = ? AND site_code = ? AND region_name = ?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute([
                    $hw_host_name ?: null,
                    $hw_mac_add ?: null,
                    $hw_ip_add ?: null,
                    $os_type ?: null,
                    $dotnet ?: null,
                    $hw_primary_role ?: null,
                    $hw_memory ?: null,
                    $hdd_capacity ?: null,
                    $hdd_free_space ?: null,
                    $utilities_str,
                    $hw_asset_num,
                    $hw_serial_num,
                    $site_code,
                    $region_id
                ]);

                $this->closeConn();
                return ['success' => true, 'message' => 'Hardware updated successfully'];
            } catch (PDOException $e) {
                $this->closeConn();
                if (strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false && $retryCount < $maxRetries) {
                    $retryCount++;
                    sleep(1);
                    continue;
                }
                return [
                    'success' => false,
                    'message' => strpos($e->getMessage(), 'SQLSTATE[HY000]') !== false
                        ? 'Database is unavailable. Please try again later.'
                        : 'Database error: ' . $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Database is unavailable after multiple attempts.'
        ];
    }
}
?>