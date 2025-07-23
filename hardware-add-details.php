<?php
    include("DAO/hardware-add-details-DAO.php");
     
    $RegionSelect = $_POST['RegionSelect'];
    $hardwareSiteModal = $_POST['hardwareSiteModal'];
    $itemSelect = $_POST['itemSelect'];
    $SubType = $_POST['SubType'];
    $itemBrand = $_POST['itemBrand'];
    $itemModel = $_POST['itemModel'];
    $asset_num = $_POST['asset_num'];
    $prefixText = $_POST['prefixText'];
    $serial_num = $_POST['serial_num'];
    $date = $_POST['date'];
    $acquired_value = $_POST['acquired_value'];
    $assetIdCombined = $prefixText . ' ' . $asset_num;
    $hw_status = $_POST['hw_status'];


    $action = new addHardwareDAO();
    $action->addHardware($RegionSelect, $hardwareSiteModal, $itemSelect, $SubType, $itemBrand, $itemModel, $asset_num, $serial_num, $date, $acquired_value, $assetIdCombined, $hw_status);
