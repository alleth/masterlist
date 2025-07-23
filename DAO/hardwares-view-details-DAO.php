<?php

include "BaseDAO.php";

class viewHardwareDetailsDAO extends BaseDAO {
    function viewHardwareDetails($site_code) {
        $this->openConn();

        $sql = "SELECT hw.hw_id, r.region_name, s.site_code, s.site_name, hw.item_desc, hw.hw_brand_name, hw.hw_model, hw.hw_asset_num, hw.hw_serial_num
            FROM hw_tbl hw
            JOIN site_list_tbl s ON hw.site_code = s.site_code
            JOIN region_tbl r ON s.region_id = r.region_id
            WHERE hw.site_code = ? AND hw.hw_status = 'On Site'
            ORDER BY hw.item_desc
        ";

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $site_code);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr id='{$row['hw_id']}'>";
            echo "<td>{$row['region_name']}</td>";
            echo "<td>{$row['site_code']} &ndash; {$row['site_name']}</td>";
            echo "<td>{$row['item_desc']}</td>";
            echo "<td>{$row['hw_brand_name']}</td>";
            echo "<td>{$row['hw_model']}</td>";
            echo "<td>{$row['hw_asset_num']}</td>";
            echo "<td>{$row['hw_serial_num']}</td>";
            echo "<td>
                <button title='Edit' class='btn btn-outline-warning btn-sm' onclick='hardwareUpdate({$row['hw_id']})'>
                    <span class='fas fa-edit'></span>
                </button>
                <button title='Edit 2' class='btn btn-outline-success btn-sm' onclick='hardwareUpdate2({$row['hw_id']})'>
                    <span class='fas fa-edit'></span>
                </button>
                <button title='Delete' class='btn btn-outline-danger btn-sm' onclick='hardwareDelete({$row["hw_id"]})'>
                    <span class='fas fa-trash'></span>
                </button>

                </td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}

/*
    include "BaseDAO.php";

    class viewHardwareDetailsDAO extends BaseDAO {
        function viewHardwareDetails($site_name){
            $this->openConn();
            $stmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE site_code = ? AND hw_status = 'On Site' ORDER BY item_desc");
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

                echo "<tr id='$row[0]'>";
                echo "<td>".$get_region['region_name']."</td>";
                echo "<td>$row[2] &ndash; ".$get_site['site_name']."</td>";
                echo "<td>$row[5]</td>";
                echo "<td>$row[6]</td>";
                echo "<td>$row[7]</td>";
                echo "<td>$row[8]</td>";
                echo "<td>$row[9]</td>";
                echo "<td>
                    <button title='Edit' class='btn btn-outline-warning btn-sm' onclick='hardwareUpdate(".$row[0].")'><span class='fas fa-edit'></span></button>
                    <button title='Edit 2' class='btn btn-outline-success btn-sm' onclick='hardwareUpdate2(".$row[0].")'><span class='fas fa-edit'></span></button>
                    <button title='Delete' class='btn btn-outline-danger btn-sm' onclick='hardwareDelete(".$row[0].")'><span class='fas fa-trash'></span></button>
                    </td>";
                echo "</tr>";
            }
            $this->closeConn();
        }
    }
*/