<?php
require_once("./codereplacer/homeCodeReplace.php");
$connx = Connection::getInstance();
require_once('./view/headerview.html');
ob_start('homeCodeReplace');
require_once('./view/accueilview.html');
ob_end_flush();
?>