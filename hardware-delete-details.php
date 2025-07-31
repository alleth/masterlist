<?php

include "DAO/hardware-delete-details-DAO.php";

$hw_id = $_POST['hw_id'] ?? null;

if ($hw_id !== null) {
    $handler = new HardwarePulloutDAO();
    $handler->pulloutById($hw_id); // This should echo "success" or "error"
} else {
    echo "invalid";
}
