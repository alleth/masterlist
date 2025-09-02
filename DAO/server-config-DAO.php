<?php
include 'BaseDAO.php';

class ServerConfigDAO extends BaseDAO {

    public function getRegions() {
        $retryCount = 0;
        $maxRetries = 2;

        while ($retryCount <= $maxRetries) {
            try {
                $this->openConn();
                $stmt = $this->dbh->prepare("SELECT region_id, region_name FROM region_tbl ORDER BY region_id");
                $stmt->execute();
                $regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->closeConn();

                return [
                    'success' => true,
                    'data' => $regions
                ];
            } catch (PDOException $e) {
                $this->closeConn();
                file_put_contents('debug.log', date('Y-m-d H:i:s') . ' - PDO Error in getRegions: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
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

    public function getSitesByRegion($regionId) {
        $retryCount = 0;
        $maxRetries = 2;

        while ($retryCount <= $maxRetries) {
            try {
                $this->openConn();
                $stmt = $this->dbh->prepare("SELECT site_code, site_name FROM site_list_tbl WHERE region_id = ? ORDER BY site_code");
                $stmt->execute([$regionId]);
                $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->closeConn();

                return [
                    'success' => true,
                    'data' => $sites
                ];
            } catch (PDOException $e) {
                $this->closeConn();
                file_put_contents('debug.log', date('Y-m-d H:i:s') . ' - PDO Error in getSitesByRegion: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
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
                $sql = "SELECT hw_asset_num, hw_model, hw_serial_num, hw_host_name, hw_mac_add, hw_ip_add, 
                               os_type, dotnet, hw_memory, hdd_capacity, hdd_free_space
                        FROM hw_tbl 
                        WHERE item_desc = 'CPU-Server' AND region_name = ? AND site_code = ? AND hw_status = 'On Site'";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute([$regionId, $siteCode]);
                $hardware = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->closeConn();

                return ['success' => true, 'data' => $hardware];
            } catch (PDOException $e) {
                $this->closeConn();
                file_put_contents('debug.log', date('Y-m-d H:i:s') . ' - PDO Error in getHardwareByRegionAndSite: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
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

    public function updateHardware($hw_asset_num, $hw_serial_num, $site_code, $region_id, $hw_host_name, $hw_mac_add, $hw_ip_add, $os_type, $dotnet, $hw_memory, $hdd_capacity, $hdd_free_space) {
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

                // Update hardware record
                $sql = "UPDATE hw_tbl SET 
                        hw_host_name = ?, 
                        hw_mac_add = ?, 
                        hw_ip_add = ?, 
                        os_type = ?, 
                        dotnet = ?, 
                        hw_memory = ?, 
                        hdd_capacity = ?, 
                        hdd_free_space = ?
                        WHERE hw_asset_num = ? AND hw_serial_num = ? AND site_code = ? AND region_name = ?";
                $stmt = $this->dbh->prepare($sql);
                $stmt->execute([
                    $hw_host_name ?: null,
                    $hw_mac_add ?: null,
                    $hw_ip_add ?: null,
                    $os_type ?: null,
                    $dotnet ?: null,
                    $hw_memory ?: null,
                    $hdd_capacity ?: null,
                    $hdd_free_space ?: null,
                    $hw_asset_num,
                    $hw_serial_num,
                    $site_code,
                    $region_id
                ]);

                $this->closeConn();
                return ['success' => true, 'message' => 'Hardware updated successfully'];
            } catch (PDOException $e) {
                $this->closeConn();
                file_put_contents('debug.log', date('Y-m-d H:i:s') . ' - PDO Error in updateHardware: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
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