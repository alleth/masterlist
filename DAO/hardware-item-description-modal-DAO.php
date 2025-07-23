<?php
include "BaseDAO.php";

class OptionHandler extends BaseDAO {
    private $allowed_tables = ['item_description'];
    private $allowed_columns = ['item_desc'];

    public function fetchOptions($table, $column) {
        if (!in_array($table, $this->allowed_tables) || !in_array($column, $this->allowed_columns)) {
            throw new Exception("Invalid table or column");
        }

        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT DISTINCT `$column` FROM `$table` ORDER BY `$column` ASC");
        $stmt->execute();
        $options = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $this->closeConn();

        return $options;
    }
}