<?php
require_once 'BaseDAO.php';

class ItemBrandDAO extends BaseDAO {
    public function getItemBrandRows() {
        $this->openConn();

        $stmt = $this->dbh->prepare("SELECT id, item_desc, brand FROM item_brand");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->closeConn();

        if (empty($result)) {
            return '<tr><td colspan="4" class="text-center">No data found.</td></tr>';
        }

        $html = '';
        foreach ($result as $row) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['item_desc']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['brand']) . '</td>';
            $html .= '<td style="text-align: right;">
                        <button title="Delete Brand" class="btn btn-outline-danger btn-sm delete-brand-btn" data-id="' . $row['id'] . '">
                            <i class="fas fa-trash"></i>
                        </button>

                    </td>';
            $html .= '</tr>';
        }

        return $html;
    }

}
