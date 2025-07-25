<?php

include "BaseDAO.php";

class CpuPcDetailsDAO extends BaseDAO {
    function getCpuPcDetails($site_code = null) {
        $this->openConn();

        $sql = "SELECT 
                    r.region_name, 
                    s.site_name,
                    CONCAT(hw.hw_asset_num, ' / ', hw.hw_serial_num) AS asset_serial,
                    hw.hw_host_name,           
                    hw.hw_ip_add,            
                    hw.hw_mac_add,          
                    hw.hw_host_name AS hw_workstep     
                FROM hw_tbl hw
                JOIN site_list_tbl s ON hw.site_code = s.site_code
                JOIN region_tbl r ON s.region_id = r.region_id
                WHERE hw.item_desc = 'CPU-PC'";

        // Add filtering by site_code only if provided
        if (!empty($site_code)) {
            $sql .= " AND hw.site_code = ?";
        }

        $sql .= " ORDER BY hw.hw_id DESC";

        $stmt = $this->dbh->prepare($sql);

        if (!empty($site_code)) {
            $stmt->bindParam(1, $site_code);
        }

        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<tr><td colspan='8' class='text-center text-muted'>No CPU-PC records found.</td></tr>";
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['region_name']}</td>";
            echo "<td>{$row['site_name']}</td>";
            echo "<td>{$row['asset_serial']}</td>";
            echo "<td>{$row['hw_host_name']}</td>";
            echo "<td>{$row['hw_ip_add']}</td>";
            echo "<td>{$row['hw_mac_add']}</td>";
            echo "<td>{$row['hw_workstep']}</td>";
            echo "<td>
                    <button class='btn btn-warning btn-sm' onclick='hardwareUpdate(this)'>
                        <i class='fas fa-edit'></i>
                    </button>
                  </td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}
