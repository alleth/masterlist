<?php
include "BaseDAO.php";

class addSiteDetailsDAO extends BaseDAO {
    // Check for exact duplicate (site_name, office_type, site_code)
    function checkExactMatch($site_name, $office_type, $site_code) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("
                SELECT COUNT(*) 
                FROM site_list_tbl 
                WHERE site_name = ? AND office_type = ? AND site_code = ?
            ");
            $stmt->bindParam(1, $site_name);
            $stmt->bindParam(2, $office_type);
            $stmt->bindParam(3, $site_code);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $this->closeConn();
            return $count > 0;
        } catch (PDOException $e) {
            $this->closeConn();
            throw new Exception('Database error checking exact match: ' . $e->getMessage());
        }
    }

    // Check for partial match (site_name, office_type)
    function checkNameTypeMatch($site_name, $office_type, $site_code) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("
                SELECT COUNT(*) 
                FROM site_list_tbl 
                WHERE site_name = ? AND office_type = ? AND site_code != ?
            ");
            $stmt->bindParam(1, $site_name);
            $stmt->bindParam(2, $office_type);
            $stmt->bindParam(3, $site_code);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $this->closeConn();
            return $count > 0;
        } catch (PDOException $e) {
            $this->closeConn();
            throw new Exception('Database error checking name and type match: ' . $e->getMessage());
        }
    }

    function addSiteDetails($region_name, $site_code, $site_name, $office_type, $site_address, $site_partnership, $trxn_catered) {
        try {
            $this->openConn();

            // Check for duplicate site_code
            $checkStmt = $this->dbh->prepare("SELECT COUNT(*) FROM site_list_tbl WHERE site_code = ?");
            $checkStmt->bindParam(1, $site_code);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                $this->closeConn();
                return ['success' => false, 'message' => 'Duplicate Entry: Site Code already exists'];
            }

            // Insert new site
            $stmt = $this->dbh->prepare("
                INSERT INTO site_list_tbl (site_code, site_name, region_id, office_type, site_address, site_partnership, trxn_catered, physical_site_count)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bindParam(1, $site_code);
            $stmt->bindParam(2, $site_name);
            $stmt->bindParam(3, $region_name);
            $stmt->bindParam(4, $office_type);
            $stmt->bindParam(5, $site_address);
            $stmt->bindParam(6, $site_partnership);
            $stmt->bindParam(7, $trxn_catered);

            $physical_site_count = 1;
            $stmt->bindParam(8, $physical_site_count);

            $stmt->execute();

            $this->closeConn();
            return ['success' => true, 'message' => 'New site added successfully'];
        } catch (PDOException $e) {
            $this->closeConn();
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>