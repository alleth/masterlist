<?php
require_once 'BaseDAO.php';

class ItemDescriptionDAO extends BaseDAO {

    public function getItemDescriptionTableRows() {
        $this->openConn();

        $sql = "SELECT item_id, item_desc FROM item_description";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        $rows = '';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows .= '<tr>
                <td>' . htmlspecialchars($row['item_desc']) . '</td>
                <td style="text-align: right;">
                    <button title="Delete Model" class="btn btn-outline-danger btn-sm delete-item-description-btn" data-id="' . $row['item_id'] . '">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>';
        }

        $this->closeConn();

        return $rows;
    }
}
?>
