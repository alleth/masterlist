<?php
include "BaseDAO.php";

class CpuPcUpdateDAO extends BaseDAO {
    function updateCpuPcDetails($hw_id, $hw_host_name, $hw_ip_add, $os_type, $hw_primary_role, $hw_mac_add) {
        $this->openConn();

        try {
            $stmt = $this->dbh->prepare("
                UPDATE hw_tbl
                SET hw_host_name = ?, 
                    hw_ip_add = ?, 
                    os_type = ?, 
                    hw_primary_role = ?, 
                    hw_mac_add = ?
                WHERE hw_id = ?
            ");
            $stmt->bindParam(1, $hw_host_name);
            $stmt->bindParam(2, $hw_ip_add);
            $stmt->bindParam(3, $os_type);
            $stmt->bindParam(4, $hw_primary_role);
            $stmt->bindParam(5, $hw_mac_add);
            $stmt->bindParam(6, $hw_id);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        CPU-PC information updated successfully!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Failed to update CPU-PC information.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Error: " . $e->getMessage() . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }

        $this->closeConn();
    }
}
?>
