<?php
include "BaseDAO.php";
class viewDataDAO extends BaseDAO {
    function displayData ($hw_type){
        $status = "On site";
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_status = ? AND sub_major_type = ?");
        $stmt->bindparam(1, $status);
        $stmt->bindParam(2, $hw_type);
        $stmt->execute();

        $chk_age = "";
        while ($row = $stmt->fetch()){

            echo "<tr onclick='viewHWDetails(".$row[0].")' style='cursor:pointer;'>";

            $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
            $region_name->bindParam(1, $row[1]);
            $region_name->execute();

            while ($region_row = $region_name->fetch()){
                $getRegion = $region_row[1];
            }

            echo "<td>".$getRegion."</td>";//region_name

            $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
            $site_name->bindParam(1, $row[2]);
            $site_name->execute();

            // Initialize the variable with a default value
            $get_siteName = "Unknown site";

            if ($site_row = $site_name->fetch()) {
                $get_siteName = $site_row[2]; // Assign the actual site name if found
            }


            echo "<td>".$row[2]."</td>";//site_code
            echo "<td>".$get_siteName."</td>";//site_name
            echo "<td>".$row[6]."</td>";//brand_name
            echo "<td>".$row[7]."</td>";//hw_model
            echo "<td>".$row[8]."</td>";//asset_num
            echo "<td>".$row[9]."</td>";//serial_num

            $purchase_date = $row[10]; // Retrieve date from database

            if (empty($purchase_date) || $purchase_date == '0000-00-00' || $purchase_date == '-' || strtotime($purchase_date) === false) {
                echo "<td>Unknown</td>"; // Display 'Unknown' for unidentified dates
            } else {
                $purchase_date = new DateTime($purchase_date);
                $current_date = new DateTime();
                $interval = $purchase_date->diff($current_date);

                echo "<td>" . $interval->y . " Year(s)</td>"; // Display hardware age
            }
            echo "<td>".$row[12]."</td>";//status
            echo "</tr>";
        }

        $this->closeConn();
    }
}