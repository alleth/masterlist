<?php
include "BaseDAO.php";

class addSiteDetailsDAO extends BaseDAO {
    function addSiteDetails($region_name, $site_code, $site_name, $office_type, $site_address, $site_partnership) {
        $this->openConn();

        // Check if site_code already exists
        $checkStmt = $this->dbh->prepare("SELECT COUNT(*) FROM site_list_tbl WHERE site_code = ?");
        $checkStmt->bindParam(1, $site_code);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo "Duplicate Entry: Site Code already exists!";
        } else {
            // Insert new site
            $stmt = $this->dbh->prepare("INSERT INTO site_list_tbl (site_code, site_name, region_id, office_type, site_address, site_partnership) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $site_code);
            $stmt->bindParam(2, $site_name);
            $stmt->bindParam(3, $region_name);
            $stmt->bindParam(4, $office_type);
            $stmt->bindParam(5, $site_address);
            $stmt->bindParam(6, $site_partnership);
            $stmt->execute();

            echo "New site added successfully!";
        }

        $this->closeConn();
    }
}
