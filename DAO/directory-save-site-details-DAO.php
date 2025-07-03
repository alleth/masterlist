<?php
include "BaseDAO.php";
class saveSiteDetailsDAO extends BaseDAO {
    function saveSiteDetails($site_id, $region_name, $site_code, $site_name, $office_type, $site_address, $site_partnership, $trxn_catered, $force = false) {
        try {
            $this->openConn();

            // Check if site_code exists for a different site_id
            $checkStmt = $this->dbh->prepare("SELECT COUNT(*) FROM site_list_tbl WHERE site_code = ? AND site_id != ?");
            $checkStmt->bindParam(1, $site_code);
            $checkStmt->bindParam(2, $site_id);
            $checkStmt->execute();
            $siteCodeExists = $checkStmt->fetchColumn();

            if ($siteCodeExists > 0) {
                return ['success' => false, 'message' => 'Duplicate Entry: Site Code already exists.'];
            }

            // Check if site_name + office_type exists with different site_code
            $checkMatchStmt = $this->dbh->prepare("SELECT site_code FROM site_list_tbl WHERE site_name = ? AND office_type = ? AND site_id != ?");
            $checkMatchStmt->bindParam(1, $site_name);
            $checkMatchStmt->bindParam(2, $office_type);
            $checkMatchStmt->bindParam(3, $site_id);
            $checkMatchStmt->execute();
            $existing = $checkMatchStmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                if (!$force) {
                    return [
                        'success' => false,
                        'dualConflict' => true,
                        'message' => 'Site name and office type already exist with a different code: ' . $existing['site_code']
                    ];
                }
            }

            $existStmt = $this->dbh->prepare("SELECT COUNT(*) FROM site_list_tbl WHERE site_id = ?");
            $existStmt->bindParam(1, $site_id);
            $existStmt->execute();
            if ($existStmt->fetchColumn() == 0) {
                return ['success' => false, 'message' => 'Site not found.'];
            }

            $stmt = $this->dbh->prepare("
                UPDATE site_list_tbl 
                SET site_code = ?, site_name = ?, site_address = ?, region_id = ?, office_type = ?, site_partnership = ?, trxn_catered = ?
                WHERE site_id = ?
            ");
            $stmt->bindParam(1, $site_code);
            $stmt->bindParam(2, $site_name);
            $stmt->bindParam(3, $site_address);
            $stmt->bindParam(4, $region_name);
            $stmt->bindParam(5, $office_type);
            $stmt->bindParam(6, $site_partnership);
            $stmt->bindParam(7, $trxn_catered);
            $stmt->bindParam(8, $site_id);
            $stmt->execute();

            $this->closeConn();
            return ['success' => true, 'message' => 'Site updated successfully'];
        } catch (PDOException $e) {
            $this->closeConn();
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>
