<?php
include "BaseDAO.php";

class viewDirectorySpecificRegionDAO extends BaseDAO {
    function viewDirectorySpecificRegion($region_name) {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM site_list_tbl where region_id = ? ORDER BY site_code");
        $stmt->bindParam(1, $region_name);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            // Fetch region name
            $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_name->bindParam(1, $row[4]);
            $region_name->execute();

            $region_data = "Unidentified"; // Default value
            while ($row_region = $region_name->fetch()) {
                $region_data = !empty($row_region[1]) ? $row_region[1] : "Unidentified";
            }

            // Output the table row with validation
            echo "<tr id='".$row['site_id']."'>";
            echo "<td>" . (!empty($region_data) ? $region_data : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[5]) ? $row[5] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[1]) ? $row[1] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[2]) ? $row[2] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[3]) ? $row[3] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[6]) ? $row[6] : "Unidentified") . "</td>";
            echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='siteFunction(".$row['site_id'].")'><span class='fas fa-edit'></span></button></td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}
