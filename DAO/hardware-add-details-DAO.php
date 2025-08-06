
<?php

include "BaseDAO.php";

class addHardwareDAO extends BaseDAO {
    function addHardware($RegionSelect, $hardwareSiteModal, $itemSelect, $SubType, $itemBrand, $itemModel, $asset_num, $serial_num, $date, $acquired_value, $assetIdCombined, $hw_status) {
        try {
            $this->openConn();

            // Normalize the asset number for comparison
            $normalizedAssetId = trim(strtolower($assetIdCombined));
            $normalizedSerialNum = trim(strtolower($serial_num));


            // === Asset Number Exists (excluding "Unreadable" and "No Tag") ===
            $assetExists = 0;
            $assetSite = "";
            if ($normalizedAssetId !== "unreadable" && $normalizedAssetId !== "no tag") {
                $checkAssetStmt = $this->dbh->prepare("SELECT site_code FROM hw_tbl WHERE hw_asset_num = ? AND hw_status = 'On Site' LIMIT 1");
                $checkAssetStmt->bindParam(1, $assetIdCombined);
                $checkAssetStmt->execute();
                if ($row = $checkAssetStmt->fetch(PDO::FETCH_ASSOC)) {
                    $assetExists = 1;
                    $assetSite = $row['site_code'];
                }
            }

            // === Serial Number Exists (excluding "Unreadable" and "None") ===
            $serialExists = 0;
            $serialSite = "";
            if ($normalizedSerialNum !== "unreadable" && $normalizedSerialNum !== "none") {
                $checkSerialStmt = $this->dbh->prepare("SELECT site_code FROM hw_tbl WHERE BINARY hw_serial_num = ? AND hw_status = 'On Site' LIMIT 1");
                $checkSerialStmt->bindParam(1, $serial_num);
                $checkSerialStmt->execute();
                if ($row = $checkSerialStmt->fetch(PDO::FETCH_ASSOC)) {
                    $serialExists = 1;
                    $serialSite = $row['site_code'];
                }
            }

            // === Return detailed message based on real data ===
            if ($assetExists && $serialExists) {
                echo "Asset Number and Serial Number Already Exist on sites: Asset - " . htmlspecialchars($assetSite) . ", Serial - " . htmlspecialchars($serialSite);
                return;
            } elseif ($assetExists) {
                echo "Asset Number Already Exists on site: " . htmlspecialchars($assetSite);
                return;
            } elseif ($serialExists) {
                echo "Serial Number Already Exists on site: " . htmlspecialchars($serialSite);
                return;
            }


            // Insert if no duplicates (or if exempted)
            $stmt = $this->dbh->prepare("
                INSERT INTO hw_tbl (
                    region_name, site_code, sub_major_type, item_desc, hw_brand_name, hw_model,
                    hw_asset_num, hw_serial_num, hw_date_acq, hw_acq_val, hw_status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bindParam(1, $RegionSelect);
            $stmt->bindParam(2, $hardwareSiteModal);
            $stmt->bindParam(3, $SubType);
            $stmt->bindParam(4, $itemSelect);
            $stmt->bindParam(5, $itemBrand);
            $stmt->bindParam(6, $itemModel);
            $stmt->bindParam(7, $assetIdCombined);
            $stmt->bindParam(8, $serial_num);
            $stmt->bindParam(9, $date);
            $stmt->bindParam(10, $acquired_value);
            $stmt->bindParam(11, $hw_status);

            $stmt->execute();

            echo "success";
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } finally {
            $this->closeConn();
        }
    }
}