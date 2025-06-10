<?php

include "BaseDAO.php";

class addHardwareDAO extends BaseDAO {
    function addHardware($RegionSelect, $hardwareSiteModal, $itemSelect, $itemBrand, $itemModel, $asset_num, $serial_num, $date, $acquired_value) {
        $this->openConn();

        // Check if serial number already exists
        $checkSerialStmt = $this->dbh->prepare("SELECT COUNT(*) FROM hw_tbl WHERE hw_serial_num = ?");
        $checkSerialStmt->bindParam(1, $serial_num);
        $checkSerialStmt->execute();
        $serialRecord = $checkSerialStmt->fetchColumn();

        // Check if asset number already exists
        $checkAssetStmt = $this->dbh->prepare("SELECT COUNT(*) FROM hw_tbl WHERE hw_asset_num = ?");
        $checkAssetStmt->bindParam(1, $asset_num);
        $checkAssetStmt->execute();
        $assetRecord = $checkAssetStmt->fetchColumn();

        // Normalize input for special case checking
        $normalizedAsset = strtolower(trim($asset_num));
        $normalizedSerial = strtolower(trim($serial_num));

        $allowOverride = ($normalizedAsset === 'unreadable' || $normalizedAsset === 'n/a' || $normalizedSerial === 'unreadable' || $normalizedSerial === 'n/a');

        //if (($assetRecord > 0 || $serialRecord > 0) && !$allowOverride) {
            if ($assetRecord > 0 && $serialRecord > 0) {
                $assetDataStmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_asset_num = ?");
                $assetDataStmt->bindParam(1, $asset_num);
                $assetDataStmt->execute();
                $assetData = $assetDataStmt->fetch(PDO::FETCH_ASSOC);
                echo "Asset Number and Serial Number Already Exist on site ";
                echo "" . htmlspecialchars($assetData['site_code']) . "";
            } else if (($assetRecord > 0) && !$allowOverride) {
                $assetDataStmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_asset_num = ?");
                $assetDataStmt->bindParam(1, $asset_num);
                $assetDataStmt->execute();
                $assetData = $assetDataStmt->fetch(PDO::FETCH_ASSOC);
                echo "Asset Number Already Exist on site ";
                echo "" . htmlspecialchars($assetData['site_code']) . "";
            } else if (($serialRecord > 0) && !$allowOverride) {
                $serialDataStmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_serial_num = ?");
                $serialDataStmt->bindParam(1, $serial_num);
                $serialDataStmt->execute();
                $serialData = $serialDataStmt->fetch(PDO::FETCH_ASSOC);
                echo "Serial Number Already Exist on site ";
                echo "" . htmlspecialchars($serialData['site_code']) . "";
            }
        //} 
        else {
            // Proceed with insertion
            $stmt = $this->dbh->prepare("INSERT INTO hw_tbl (region_name, site_code, item_desc, hw_brand_name, hw_model, hw_asset_num, hw_serial_num, hw_date_acq, hw_acq_val) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $RegionSelect);
            $stmt->bindParam(2, $hardwareSiteModal);
            $stmt->bindParam(3, $itemSelect);
            $stmt->bindParam(4, $itemBrand);
            $stmt->bindParam(5, $itemModel);
            $stmt->bindParam(6, $asset_num);
            $stmt->bindParam(7, $serial_num);
            $stmt->bindParam(8, $date);
            $stmt->bindParam(9, $acquired_value);
            $stmt->execute();

            echo "Added Successfully";
        }

        $this->closeConn();
    }
}

/*
////----------------------------------------1st design---------------------------------------------------------------------------------------------
class addHardwareDAO extends BaseDAO {
    function addHardware($RegionSelect, $hardwareSiteModal, $itemSelect, $itemBrand, $itemModel, $asset_num, $serial_num, $date, $acquired_value) {
        $this->openConn();

            // Check if site_code already exists
        $checkSerialStmt = $this->dbh->prepare("SELECT COUNT(*) FROM hw_tbl WHERE hw_serial_num = ?");
        $checkSerialStmt->bindParam(1, $serial_num);
        $checkSerialStmt->execute();
        $serialRecord = $checkSerialStmt->fetchColumn();

        $checkAssetStmt = $this->dbh->prepare("SELECT COUNT(*) FROM hw_tbl WHERE hw_asset_num = ?");
        $checkAssetStmt->bindParam(1, $asset_num);
        $checkAssetStmt->execute();
        $assetRecord = $checkAssetStmt->fetchColumn();

        if ($assetRecord > 0 && $serialRecord > 0) {
            $assetDataStmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_asset_num = ?");
            $assetDataStmt->bindParam(1, $asset_num);
            $assetDataStmt->execute();
            $assetData = $assetDataStmt->fetch(PDO::FETCH_ASSOC);
            echo "Asset Number and Serial Number Already Exist on site ";
            echo "" . htmlspecialchars($assetData['site_code']) . "";
        } else if ($assetRecord > 0) {
            $assetDataStmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_asset_num = ?");
            $assetDataStmt->bindParam(1, $asset_num);
            $assetDataStmt->execute();
            $assetData = $assetDataStmt->fetch(PDO::FETCH_ASSOC);
            echo "Asset Number Already Exist on site ";
            echo "" . htmlspecialchars($assetData['site_code']) . "";
        } else if ($serialRecord > 0) {
            $serialDataStmt = $this->dbh->prepare("SELECT * FROM hw_tbl WHERE hw_serial_num = ?");
            $serialDataStmt->bindParam(1, $serial_num);
            $serialDataStmt->execute();
            $serialData = $serialDataStmt->fetch(PDO::FETCH_ASSOC);
            echo "Serial Number Already Exist on site ";
            echo "" . htmlspecialchars($serialData['site_code']) . "";
        } else {
            $stmt = $this->dbh->prepare("INSERT INTO hw_tbl (region_name, site_code, item_desc, hw_brand_name, hw_model, hw_asset_num, hw_serial_num, hw_date_acq, hw_acq_val) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $RegionSelect);
            $stmt->bindParam(2, $hardwareSiteModal);
            $stmt->bindParam(3, $itemSelect);
            $stmt->bindParam(4, $itemBrand);
            $stmt->bindParam(5, $itemModel);
            $stmt->bindParam(6, $asset_num);
            $stmt->bindParam(7, $serial_num);
            $stmt->bindParam(8, $date);
            $stmt->bindParam(9, $acquired_value);
            $stmt->execute();

            echo "Added Successfully";
        }

        $this->closeConn();
    }
}
*/