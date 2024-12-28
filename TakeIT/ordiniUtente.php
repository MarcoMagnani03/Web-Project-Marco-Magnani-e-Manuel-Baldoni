<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

$templateParams["ordini"] = $dbh->getOrdiniUtente($_SESSION["email"]);
$templateParams["ordini_max_price"] = $dbh->getMaxPriceOfOrders();

require_once 'template/base.php';
?>