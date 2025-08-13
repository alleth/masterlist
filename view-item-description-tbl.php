<?php
require_once 'DAO/view-item-description-tblDAO.php';

$dao = new ItemDescriptionDAO();
$html = $dao->getItemDescriptionTableRows();

echo $html;
exit;
