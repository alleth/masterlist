<?php
require_once "BaseDAO.php";

class FacilitiesShowDAO extends BaseDAO {
    public function getFacilitiesByRegion($region) {
        $this->openConn();

        $sql = "SELECT site_code, site_name, node_count, node_working, node_defective, node_available,
                       outlet_count, outlet_working, outlet_defective, outlet_available, type_electrical_con
                FROM site_list_tbl";

        if ($region !== "all") {
            $sql .= " WHERE region_id = :region";
            $stmt = $this->dbh->prepare($sql);   // ✅ use $this->dbh
            $stmt->bindParam(":region", $region);
        } else {
            $stmt = $this->dbh->prepare($sql);   // ✅ use $this->dbh
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
                            <td>{$row['node_working']}</td>
                            <td>{$row['node_defective']}</td>
                            <td>{$row['node_available']}</td>
                            <td>{$row['outlet_count']}</td>
                            <td>{$row['outlet_working']}</td>
                            <td>{$row['outlet_defective']}</td>
                            <td>{$row['outlet_available']}</td>
                            <td>{$row['type_electrical_con']}</td>
                            <td><button class='btn btn-sm btn-primary edit-btn'>Edit</button></td>
                          </tr>";
            }
            return $html;
        } else {
            return "<tr><td colspan='11' class='text-center text-muted fst-italic'>No data found</td></tr>";
        }
    }
}
