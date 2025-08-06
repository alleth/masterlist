<?php
require_once 'DAO/view-item-model-tblDAO.php';

$dao = new ItemModelDAO();
$html = $dao->getItemModelRows();

echo $html;
echo json_encode($data);
exit;
