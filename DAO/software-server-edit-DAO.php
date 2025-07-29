<?php
include "BaseDAO.php";

class CpuPcEditDAO extends BaseDAO {
    function getCpuPcDetailsById($hw_id) {
        $this->openConn();

        $sql = "SELECT hw_id, hw_host_name, hw_primary_role, hw_ip_add, hw_mac_add, os_type 
                FROM hw_tbl WHERE hw_id = ?";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $hw_id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->closeConn();

        return $data ? $data : null;
    }
}
