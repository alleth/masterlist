<?php

include "DAO/hardware-update-details-DAO2.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dao = new HardwareUpdateDAO2();
    echo $dao->updateHardware($_POST);
}



