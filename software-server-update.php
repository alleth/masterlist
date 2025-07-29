<?php
include "DAO/software-server-update-DAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hw_id = $_POST['hw_id'];
    $hw_host_name = $_POST['hw_host_name'];
    $hw_ip_add = $_POST['hw_ip_add'];
    $os_type = $_POST['os_type'];
    $hw_primary_role = $_POST['hw_primary_role'];
    $hw_mac_add = $_POST['hw_mac_add'];

    $dao = new CpuPcUpdateDAO();
    $dao->updateCpuPcDetails($hw_id, $hw_host_name, $hw_ip_add, $os_type, $hw_primary_role, $hw_mac_add);
}
?>
