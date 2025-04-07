<?php
include "BaseDAO.php";

class addHardwareDAO extends BaseDAO {
    function addHardware($RegionSelect, $hardwareSiteModal, $itemSelect, $itemBrand, $itemModel, $asset_num, $serial_num, $date, $acquired_value) {
        $this->openConn();

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

        $this->closeConn();
    }
}