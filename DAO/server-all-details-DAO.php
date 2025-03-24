<?php
include "BaseDAO.php";

class viewDetailsServerDAO extends BaseDAO {
    function viewDetailsServer() {
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE item_desc = 'Server' AND hw_status = 'On Site' ORDER BY region_name");
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            // Fetch region name
            $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_name->bindParam(1, $row[1]);
            $region_name->execute();

            $region_data = "Unidentified"; // Default value
            while ($row_region = $region_name->fetch()) {
                $region_data = !empty($row_region[1]) ? $row_region[1] : "Unidentified";
            }

            $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
            $site_name->bindParam(1, $row[2]);
            $site_name->execute();

            $site_data = "Unidentified"; // Default value
            while ($row_site = $site_name->fetch()) {
                $site_data = !empty($row_site[2]) ? $row_site[2] : "Unidentified";
            }
            // Output the table row with validation
            echo "<tr id='".$row[0]."'>";
            echo "<td>" . (!empty($region_data) ? $region_data : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[2]) ? $row[2] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($site_data) ? $site_data : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[6]) ? $row[6] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[7]) ? $row[7] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[8]) ? $row[8] : "Unidentified") . "</td>";
            echo "<td>" . (!empty($row[9]) ? $row[9] : "Unidentified") . "</td>";

            $purchase_date = $row['10']; // Retrieve date from database

            // Check if the purchase date is empty, '0000-00-00', or invalid
            if (empty($purchase_date) || $purchase_date == '0000-00-00' || strtotime($purchase_date) === false) {
                echo "<td class='text-danger'>Unknown</td>"; // Display 'Unknown' for unidentified dates
            } else {
                $purchase_date = new DateTime($purchase_date);
                $current_date = new DateTime();
                $interval = $purchase_date->diff($current_date);

                echo "<td>" . $interval->y . " Years</td>"; // Display hardware age
            }
            echo "<td>" . (!empty($row[12]) ? $row[12] : "Unidentified") . "</td>";
            echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='serverUpdate(".$row['hw_id'].")'><span class='fas fa-edit'></span></button></td>";
            echo "</tr>";
        }
        $this->closeConn();
    }
}
