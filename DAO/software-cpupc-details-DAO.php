<?php
include "BaseDAO.php";

class CpuPcDetailsDAO extends BaseDAO {
    function getCpuPcDetails($region_id = null, $site_code = null) {
        $this->openConn();

        $sql = "SELECT 
                    hw.hw_id,  /* Added hw_id for button data attribute */
                    r.region_name, 
                    s.site_name,
                    CONCAT(hw.hw_asset_num, ' / ', hw.hw_serial_num) AS asset_serial,
                    hw.hw_host_name,           
                    hw.hw_ip_add,            
                    hw.hw_mac_add,          
                    hw.os_type AS hw_workstep     
                FROM hw_tbl hw
                JOIN site_list_tbl s ON hw.site_code = s.site_code
                JOIN region_tbl r ON s.region_id = r.region_id
                WHERE hw.item_desc = 'CPU-PC'";

        // Always require region filter
        if (!empty($region_id)) {
            $sql .= " AND r.region_id = ?";
        }

        // Add site filter only if site_code is not "All Site" and not empty
        if (!empty($site_code) && $site_code !== "All Site") {
            $sql .= " AND hw.site_code = ?";
        }

        $sql .= " ORDER BY hw.hw_id DESC";

        $stmt = $this->dbh->prepare($sql);

        // Bind parameters dynamically
        $bindIndex = 1;
        if (!empty($region_id)) {
            $stmt->bindParam($bindIndex++, $region_id, PDO::PARAM_INT);
        }
        if (!empty($site_code) && $site_code !== "All Site") {
            $stmt->bindParam($bindIndex++, $site_code, PDO::PARAM_STR);
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
                    <button title='Edit' class='btn btn-outline-warning btn-sm edit-hardware-btn' data-id='{$row['hw_id']}'>
                        <span class='fas fa-edit'></span>
                    </button>
                  </td>";
            echo "</tr>";
        }

        $this->closeConn();
    }
}
