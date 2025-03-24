<?php
include "BaseDAO.php";

class viewDirectorySpecificOfficeTypeDAO extends BaseDAO {
    function viewDirectorySpecificOfficeType($region_name, $officeType) {

        $this->openConn();
        $stmt = "";

        if($region_name == "all" && $officeType !== "all_office"){
            $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE office_type = ? ORDER BY site_code");
            $stmt->bindParam(1, $officeType);
        }else{
            $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE region_id = ? AND office_type = ? ORDER BY site_code");
            $stmt->bindParam(1, $region_name);
            $stmt->bindParam(2, $officeType);
        }

        $stmt->execute();

        $rows = $stmt->fetchAll(); // Fetch all results first
        foreach ($rows as $row) {
            // Fetch region name
            $region_stmt = $this->dbh->prepare("SELECT region_name FROM region_tbl WHERE region_id = ?");
            $region_stmt->bindParam(1, $row['region_id']);
            $region_stmt->execute();
            $region_data = $region_stmt->fetchColumn() ?: "Unidentified";

            // Output table row with validation
            echo "<tr id='".$row['site_id']."'>";
            echo "<td>" . htmlspecialchars($region_data) . "</td>";
            echo "<td>" . (!empty($row['office_type']) ? htmlspecialchars($row['office_type']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['site_code']) ? htmlspecialchars($row['site_code']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['site_name']) ? htmlspecialchars($row['site_name']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['site_address']) ? htmlspecialchars($row['site_address']) : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row['site_partnership']) ? htmlspecialchars($row['site_partnership']) : "Unidentified") . "</td>";
            echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='siteFunction(".$row['site_id'].")'><span class='fas fa-edit'></span></button></td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}
