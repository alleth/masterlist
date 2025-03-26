<?php
    include "BaseDAO.php";

    class viewHardwareDetailsDAO extends BaseDAO {
        function viewHardwareDetails($site_name){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE site_code = ? ORDER BY item_desc");
            $stmt->bindParam(1, $site_name);
            $stmt->execute();

            while($row = $stmt->fetch()){

               $region_name = $this->dbh->prepare("SELECT * FROM region_tbl WHERE region_id = ?");
               $region_name->bindParam(1, $row[1]);
               $region_name->execute();

               $get_region = $region_name->fetch();

               $site_name = $this->dbh->prepare("SELECT * FROM site_list_tbl WHERE site_code = ?");
               $site_name->bindParam(1, $row[2]);
               $site_name->execute();

               $get_site = $site_name->fetch();

                echo "<tr>";
                echo "<td>".$get_region['region_name']."</td>";
                echo "<td>$row[2] &ndash; ".$get_site['site_name']."</td>";
                echo "<td>$row[5]</td>";
                echo "<td>$row[6]</td>";
                echo "<td>$row[7]</td>";
                echo "<td>$row[8]</td>";
                echo "<td>$row[9]</td>";
                echo "<td><button title='Edit' class='btn btn-outline-warning btn-sm' onclick='hardwareUpdate(".$row[0].")'><span class='fas fa-edit'></span></button></td>";
                echo "</tr>";
            }
            $this->closeConn();
        }
    }