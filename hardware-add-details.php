<?php
    include("DAO/hardware-add-details-DAO.php");
     
    $RegionSelect = $_POST['RegionSelect'];
    $hardwareSiteModal = $_POST['hardwareSiteModal'];
    $itemSelect = $_POST['itemSelect'];
    $itemBrand = $_POST['itemBrand'];
    $itemModel = $_POST['itemModel'];
    $asset_num = $_POST['asset_num'];
    $serial_num = $_POST['serial_num'];
    $date = $_POST['date'];
    $acquired_value = $_POST['acquired_value'];

    $action = new addHardwareDAO();
    $action->addHardware($RegionSelect, $hardwareSiteModal, $itemSelect, $itemBrand, $itemModel, $asset_num, $serial_num, $date, $acquired_value);

