<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

$templateParams["ordini"] = $dbh->getOrdini($_SESSION["email"]);

require_once 'template/base.php';
?>