<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

$filters = [
	"ordine" => $_GET["ordine"] ?? null,
	"prezzo_min" => $_GET['prezzo_min'] ?? null,
	"prezzo_max" => $_GET['prezzo_max'] ?? null,
	"data_arrivo_min" => $_GET['data_arrivo_min'] ?? null,
	"data_arrivo_max" => $_GET['data_arrivo_max'] ?? null,
	"data_ordine_min" => $_GET['data_ordine_min'] ?? null,
	"data_ordine_max" => $_GET['data_ordine_max'] ?? null
];

$templateParams["ordini"] = $dbh->getOrdiniUtente($_SESSION["email"], $filters);
$templateParams["ordini_max_price"] = $dbh->getMaxPriceOfOrders();

require_once 'template/base.php';
?>