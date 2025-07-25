<?php
<<<<<<< HEAD

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
=======
include "BaseDAO.php";
>>>>>>> 6a7b48c754a92bff5247c1629b0a800ca5dcef78

class viewHardwareDetailsDAO extends BaseDAO {

    private function tdCell($value) {
        $val = trim($value ?? '');
        $safeVal = htmlspecialchars($val === '' ? 'Unidentified' : $val);
        $class = $val === '' ? " class='text-danger'" : "";
        return "<td{$class}>{$safeVal}</td>";
    }

    function viewHardwareDetails($site_name = null, $region_id = null) {
        ob_clean();
        $this->openConn();

        $site_name = $site_name ?? 'all_sites';  // site_code
        $region_id = $region_id ?? 'all_region'; // region_id
        $hw_type = $_POST["hw_type"] ?? 'all_hw';

        $valid_hw_types = [
            'all_hw', 'Server', 'UPS-Server',
            'CPU-PC', 'Monitor', 'UPS-PC',
            'Keyboard', 'Mouse', 'Webcam', 'Sigpad',
            'Laserjet', 'Inkjet', 'Dot Matrix', 'Deskjet',
            'Modem', 'Router', 'Switch'
        ];

        if (!in_array($hw_type, $valid_hw_types)) {
            echo "<tr><td colspan='8' class='text-center text-danger'>Invalid hardware type selected</td></tr>";
            $this->closeConn();
            return;
        }

        // Validate site_code
        if ($site_name !== 'all_sites') {
            $stmt = $this->dbh->prepare("SELECT site_code FROM site_list_tbl WHERE TRIM(LOWER(site_code)) = TRIM(LOWER(?))");
            $stmt->bindParam(1, $site_name);
            $stmt->execute();
<<<<<<< HEAD

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
=======
            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td colspan='8' class='text-center text-danger'>Site code not found</td></tr>";
                $this->closeConn();
                return;
>>>>>>> 6a7b48c754a92bff5247c1629b0a800ca5dcef78
            }
        }
<<<<<<< HEAD
    }
*/
=======

        // Main query
        $query = "SELECT h.hw_id, r.region_name, h.site_code, h.item_desc, h.hw_brand_name, h.hw_model,
                         h.hw_asset_num, h.hw_serial_num, h.hw_status, s.site_name
                  FROM hw_tbl h
                  LEFT JOIN site_list_tbl s ON TRIM(LOWER(h.site_code)) = TRIM(LOWER(s.site_code))
                  LEFT JOIN region_tbl r ON h.region_name = r.region_id
                  WHERE h.hw_status = 'On Site'";
        $params = [];

        if ($region_id !== 'all_region') {
            $query .= " AND h.region_name = ?";
            $params[] = $region_id;
        }

        if ($site_name !== 'all_sites') {
            $query .= " AND TRIM(LOWER(h.site_code)) = TRIM(LOWER(?))";
            $params[] = $site_name;
        }

        if ($hw_type !== 'all_hw') {
            $query .= " AND TRIM(LOWER(h.item_desc)) = TRIM(LOWER(?))";
            $params[] = $hw_type;
        }

        $query .= " ORDER BY h.site_code";

        try {
            $stmt = $this->dbh->prepare($query);
            foreach ($params as $index => $param) {
                $stmt->bindValue($index + 1, $param);
            }
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) === 0) {
                echo "<tr><td colspan='8' class='text-center text-danger'>No hardware found for selected filters</td></tr>";
            } else {
                foreach ($rows as $row) {
                    $region = $row['region_name'] ?? '';
                    $site_code = trim($row['site_code'] ?? '');
                    $site_name = trim($row['site_name'] ?? '');

                    $desc = $row['item_desc'] ?? '';
                    $brand = $row['hw_brand_name'] ?? '';
                    $model = $row['hw_model'] ?? '';
                    $asset = $row['hw_asset_num'] ?? '';
                    $serial = $row['hw_serial_num'] ?? '';
                    $hw_id = htmlspecialchars($row['hw_id'] ?? '');

                    echo "<tr>";
                    echo $this->tdCell($region);

                    // Site column
                    $siteDisplay = $site_code . " – " . ($site_name !== '' ? $site_name : 'Unidentified');
                    if (strpos($siteDisplay, 'Unidentified') !== false) {
                        echo "<td class='text-danger'>" . htmlspecialchars($siteDisplay) . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($siteDisplay) . "</td>";
                    }

                    echo $this->tdCell($desc);
                    echo $this->tdCell($brand);
                    echo $this->tdCell($model);
                    echo $this->tdCell($asset);
                    echo $this->tdCell($serial);

                    // Action button
                    echo "<td>";
                    if (!empty($hw_id)) {
                        echo "<button title='Edit' class='btn btn-outline-warning btn-sm edit-hardware-btn' data-hw-id='{$hw_id}'>
                                <span class='fas fa-edit'></span>
                              </button>";
                    } else {
                        echo "<span class='text-muted'>N/A</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='8' class='text-center text-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }

        $this->closeConn();
    }
}
>>>>>>> 6a7b48c754a92bff5247c1629b0a800ca5dcef78
