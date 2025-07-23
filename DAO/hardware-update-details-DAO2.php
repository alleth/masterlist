<?php

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

