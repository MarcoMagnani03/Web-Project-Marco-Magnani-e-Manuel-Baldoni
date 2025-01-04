<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

$filters = [
	"q" => $_GET["q"] ?? null,
	"ordine" => $_GET["ordine"] ?? null,
	"prezzo_min" => $_GET['prezzo_min'] ?? null,
	"prezzo_max" => $_GET['prezzo_max'] ?? null,
	"data_arrivo_min" => $_GET['data_arrivo_min'] ?? null,
	"data_arrivo_max" => $_GET['data_arrivo_max'] ?? null,
	"data_ordine_min" => $_GET['data_ordine_min'] ?? null,
	"data_ordine_max" => $_GET['data_ordine_max'] ?? null,
	"stato" => $_GET['stato'] ?? null
];

$templateParams["ordini"] = $dbh->getOrdini($_SESSION["email"], $filters);
$templateParams["ordini_max_price"] = $dbh->getMaxPriceOfOrders();

require_once 'template/base.php';
?>