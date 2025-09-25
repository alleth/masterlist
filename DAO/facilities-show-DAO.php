<?php
require_once "BaseDAO.php";

class FacilitiesShowDAO extends BaseDAO {
    public function getFacilitiesByRegion($region) {
        $this->openConn();

        $sql = "SELECT site_code, site_name, node_count, node_available, outlet_count, outlet_available, port_count, port_available, type_electrical_con
                FROM site_list_tbl";

        if ($region !== "all") {
            $sql .= " WHERE region_id = :region";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":region", $region);
        } else {
            $stmt = $this->dbh->prepare($sql);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->closeConn();

        if ($rows) {
            $html = "";
            foreach ($rows as $row) {
                $html .= "<tr>
                            <td>{$row['site_code']} - {$row['site_name']}</td>
                            <td>{$row['node_count']}</td>
                            <td>{$row['node_available']}</td>
                            <td>{$row['outlet_count']}</td>
                            <td>{$row['outlet_available']}</td>
                            <td>{$row['port_count']}</td>
                            <td>{$row['port_available']}</td>
                            <td>{$row['type_electrical_con']}</td>
                            <td>
                                <button class='btn btn-outline-warning btn-sm edit-facilities-btn' 
                                        data-site-id='{$row['site_code']}'>
                                    <span class='fas fa-edit'></span>
                                </button>
                            </td>
                        </tr>";
            }
            return $html;
        } else {
            return "<tr><td colspan='11' class='text-center text-muted fst-italic'>No data found</td></tr>";
        }
    }
}
