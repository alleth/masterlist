<?php
include "BaseDAO.php";

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
            'all_hw', 'CPU-Server', 'UPS-SERVER',
            'CPU-PC', 'Monitor', 'UPS-PC',
            'Keyboard', 'Mouse', 'Webcam', 'Sigpad',
            'Laserjet', 'Inkjet', 'Dot Matrix', 'Deskjet',
            'Modem', 'Router', 'Switch', 'SDWAN'
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
            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td colspan='8' class='text-center text-danger'>Site code not found</td></tr>";
                $this->closeConn();
                return;
            }
        }

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
                    /* backup
                    <button title='Edit' class='btn btn-outline-warning btn-sm edit-hardware-btn' data-hw-id='{$hw_id}'>
                                <span class='fas fa-edit'></span>
                              </button>
                    */
                    echo "<td>";
                    if (!empty($hw_id)) {
                        echo "<button title='Edit 2' class='btn btn-outline-success btn-sm' onclick='hardwareUpdate2({$row['hw_id']})'>
                                    <span class='fas fa-edit'></span>
                                </button>
                                <button title='Delete' class='btn btn-outline-danger btn-sm' onclick='hardwareDelete({$row["hw_id"]})'>
                                    <span class='fas fa-trash'></span>
                                </button>
                              ";
                        /**/
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
