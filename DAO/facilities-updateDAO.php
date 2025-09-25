<?php
require_once "BaseDAO.php";

class FacilitiesUpdateDAO extends BaseDAO {
    public function updateFacilities($site_id, $data) {
        if (!$site_id) return false;

        $this->openConn();

        $sql = "UPDATE site_list_tbl 
                SET node_count = :node_count,
                    node_working = :node_working,
                    node_defective = :node_defective,
                    node_available = :node_available,
                    outlet_count = :outlet_count,
                    outlet_working = :outlet_working,
                    outlet_defective = :outlet_defective,
                    outlet_available = :outlet_available,
                    port_count = :port_count,
                    port_working = :port_working,
                    port_defective = :port_defective,
                    port_available = :port_available,
                    type_electrical_con = :type_electrical_con
                WHERE site_id = :site_id";

        $stmt = $this->dbh->prepare($sql);

        $stmt->bindParam(":node_count", $data['node_count']);
        $stmt->bindParam(":node_working", $data['node_working']);
        $stmt->bindParam(":node_defective", $data['node_defective']);
        $stmt->bindParam(":node_available", $data['node_available']);
        $stmt->bindParam(":outlet_count", $data['outlet_count']);
        $stmt->bindParam(":outlet_working", $data['outlet_working']);
        $stmt->bindParam(":outlet_defective", $data['outlet_defective']);
        $stmt->bindParam(":outlet_available", $data['outlet_available']);
        $stmt->bindParam(":port_count", $data['port_count']);
        $stmt->bindParam(":port_working", $data['port_working']);
        $stmt->bindParam(":port_defective", $data['port_defective']);
        $stmt->bindParam(":port_available", $data['port_available']);
        $stmt->bindParam(":type_electrical_con", $data['type_electrical_con']);
        $stmt->bindParam(":site_id", $site_id);

        $success = $stmt->execute();

        $this->closeConn();
        return $success;
    }
}
