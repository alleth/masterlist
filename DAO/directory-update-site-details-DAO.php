<?php
include "BaseDAO.php";
class updateSiteDetailsDAO extends BaseDAO {
    function updateSiteDetails($site_id) {
        try {
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT site_id, site_code, site_name, site_address, region_id, office_type, site_partnership, trxn_catered FROM site_list_tbl WHERE site_id = ?");
            $stmt->bindParam(1, $site_id);
            $stmt->execute();

            $record = $stmt->fetch();

            if (!$record) {
                throw new Exception("Site not found");
            }

            $regionStmt = $this->dbh->prepare("SELECT region_name FROM region_tbl WHERE region_id = ?");
            $regionStmt->bindParam(1, $record[4]);
            $regionStmt->execute();

            $response = [
                "site_id" => $record[0],
                "region_name" => $record[4], // region_id, assuming select options use region_id
                "site_code" => $record[1],
                "site_name" => $record[2],
                "office_type" => $record[5],
                "site_address" => $record[3],
                "site_partnership" => $record[6], // Changed from "partnership" to match database and JS
                "trxn_catered" => $record[7] ?: ''
            ];
            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                "error" => "Failed to fetch site details: " . $e->getMessage()
            ];
            echo json_encode($response);
        } finally {
            $this->closeConn();
        }
    }
}
?>