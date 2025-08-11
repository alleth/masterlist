<?php
include "BaseDAO.php";

class HardwareEditFetchDAO extends BaseDAO {
    function getHardwareById($hw_id) {
        $this->openConn();
        $stmt = $this->dbh->prepare("
            SELECT 
                hw.*,
                r.region_id,
                r.region_name,
                s.site_code,
                s.site_name
            FROM hw_tbl hw
            JOIN site_list_tbl s ON hw.site_code = s.site_code
            JOIN region_tbl r ON s.region_id = r.region_id
            WHERE hw.hw_id = ?
        ");
        $stmt->execute([$hw_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->closeConn();

        // Build pre-filled select options
        $region_html = "<option value='{$row['region_id']}' selected>{$row['region_name']}</option>";
        $site_html   = "<option value='{$row['site_code']}' selected>{$row['site_code']} – {$row['site_name']}</option>";
        $item_html   = "<option value='{$row['item_desc']}' selected>{$row['item_desc']}</option>";
        $brand_html  = "<option value='{$row['hw_brand_name']}' selected>{$row['hw_brand_name']}</option>";
        $model_html  = "<option value='{$row['hw_model']}' selected>{$row['hw_model']}</option>";

        return [
            'hw_id'          => $row['hw_id'],
            'hw_asset_num'   => $row['hw_asset_num'],
            'hw_serial_num'  => $row['hw_serial_num'],
            'hw_date_acq'    => $row['hw_date_acq'],
            'hw_acq_val'     => $row['hw_acq_val'],
            'sub_major_type' => $row['sub_major_type'],
            'region_id'      => $row['region_id'],
            'region_name'    => $row['region_name'],
            'region_html'    => $region_html,
            'site_html'      => $site_html,
            'item_html'      => $item_html,
            'brand_html'     => $brand_html,
            'model_html'     => $model_html,
            'hw_status'     => $row['hw_status']
        ];
    }
}
