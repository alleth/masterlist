<?php

include "BaseDAO.php";

class HardwareUpdateDAO2 extends BaseDAO {
    function updateHardware($p) {
        try {
            $this->openConn();

            $hw_id = intval($p['hw_id']);
            $assetIdCombined = trim($p['prefixText'] . ' ' . $p['asset_num']);
            $serial_num = trim($p['serial_num']);

            // === Normalize values ===
            $normalizedAssetId = strtolower($assetIdCombined);
            $normalizedSerialNum = strtolower($serial_num);

            // === Asset Number Exists (excluding "Unreadable" and "No Tag") ===
            $assetExists = 0;
            $assetSite = "";
            if ($normalizedAssetId !== "unreadable" && $normalizedAssetId !== "no tag") {
                $checkAssetStmt = $this->dbh->prepare("
                    SELECT site_code FROM hw_tbl 
                    WHERE hw_asset_num = ? AND hw_id != ? 
                    LIMIT 1
                ");
                $checkAssetStmt->bindParam(1, $assetIdCombined);
                $checkAssetStmt->bindParam(2, $hw_id);
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
                $checkSerialStmt = $this->dbh->prepare("
                    SELECT site_code FROM hw_tbl 
                    WHERE BINARY hw_serial_num = ? AND hw_id != ? 
                    LIMIT 1
                ");
                $checkSerialStmt->bindParam(1, $serial_num);
                $checkSerialStmt->bindParam(2, $hw_id);
                $checkSerialStmt->execute();
                if ($row = $checkSerialStmt->fetch(PDO::FETCH_ASSOC)) {
                    $serialExists = 1;
                    $serialSite = $row['site_code'];
                }
            }

            // === Return detailed message if conflicts exist ===
            if ($assetExists && $serialExists) {
                return "Asset Number and Serial Number Already Exist on sites: Asset - " . htmlspecialchars($assetSite) . ", Serial - " . htmlspecialchars($serialSite);
            } elseif ($assetExists) {
                return "Asset Number Already Exists on site: " . htmlspecialchars($assetSite);
            } elseif ($serialExists) {
                return "Serial Number Already Exists on site: " . htmlspecialchars($serialSite);
            }

            // === Update if no conflict ===
            $stmt = $this->dbh->prepare("
                UPDATE hw_tbl SET
                    item_desc = :item_desc,
                    hw_brand_name = :brand,
                    hw_model = :model,
                    hw_asset_num = :asset,
                    hw_serial_num = :serial,
                    hw_date_acq = :date,
                    hw_acq_val = :acq,
                    sub_major_type = :sub_type,
                    site_code = :site_code,
                    hw_status = :hw_status
                WHERE hw_id = :id
            ");

            $stmt->execute([
                ':item_desc' => $p['itemSelect'],
                ':brand'     => $p['itemBrand'],
                ':model'     => $p['itemModel'],
                ':asset'     => $assetIdCombined,
                ':serial'    => $serial_num,
                ':date'      => $p['date'],
                ':acq'       => $p['acquired_value'],
                ':sub_type'  => $p['subType'],
                ':site_code' => $p['siteCode'],
                ':hw_status' => $p['hw_status'],
                ':id'        => $hw_id
            ]);

            return "success";

        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        } finally {
            $this->closeConn();
        }
    }
}

/*
include "BaseDAO.php";

class HardwareUpdateDAO2 extends BaseDAO {
    function updateHardware($p) {
      try {
          $this->openConn();

          $stmt = $this->dbh->prepare("
              UPDATE hw_tbl SET
                  item_desc = :item_desc,
                  hw_brand_name = :brand,
                  hw_model = :model,
                  hw_asset_num = :asset,
                  hw_serial_num = :serial,
                  hw_date_acq = :date,
                  hw_acq_val = :acq,
                  sub_major_type = :sub_type,
                  site_code = :site_code
              WHERE hw_id = :id
          ");

          $stmt->execute([
              ':item_desc' => $p['itemSelect'],
              ':brand'     => $p['itemBrand'],
              ':model'     => $p['itemModel'],
              ':asset'     => $p['prefixText'] . ' ' . $p['asset_num'],
              ':serial'    => $p['serial_num'],
              ':date'      => $p['date'],
              ':acq'       => $p['acquired_value'],
              ':sub_type'  => $p['subType'],
              ':site_code' => $p['siteCode'],
              ':id'        => intval($p['hw_id'])
          ]);

          $this->closeConn();
          return "success";

      } catch (PDOException $e) {
          return "Error: " . $e->getMessage();
      }
  }
}
*/
