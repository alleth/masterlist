<?php
require_once 'DAO/view-item-brand-tblDAO.php';

$dao = new ItemBrandDAO();
$html = $dao->getItemBrandRows();

echo $html;
echo json_encode($data);
exit;
