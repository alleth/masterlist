<?php
require_once "BaseDAO.php";

class FacilitiesEditDAO extends BaseDAO {
    public function getSiteById($site_id) {
        $this->openConn();

        $sql = "SELECT site_id, node_count, node_working, node_defective, node_available, outlet_count, outlet_working, outlet_defective, outlet_available,
                        port_count, port_working, port_defective, port_available, type_electrical_con
                FROM site_list_tbl
                WHERE site_code = :site_id";  // adjust if your PK column is site_id

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(":site_id", $site_id);
        $stmt->execute();

        $site = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->closeConn();

        return $site ?: null;
    }
}
