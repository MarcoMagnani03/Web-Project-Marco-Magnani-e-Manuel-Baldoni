<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Home";
$templateParams["nome"] = "lista-prodotti.php";
$templateParams["css"] = "lista-prodotti.css";

$templateParams["prodotti"] = $dbh->getProdotti();
$templateParams["tipologie_prodotti"] = $dbh->getTipologieProdotti();

require_once 'template/base.php';
?>