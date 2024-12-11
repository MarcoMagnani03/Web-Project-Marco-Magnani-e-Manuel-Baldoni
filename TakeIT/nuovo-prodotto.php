<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Nuovo prodotto";
$templateParams["nome"] = "nuovo-prodotto-form.php";
$templateParams["css"] = "nuovo-prodotto.css";
$templateParams["errorenuovoprodotto"] = "";

$templateParams["tipologie_prodotti"] = $dbh->getTipologieProdotto();
$templateParams["marche"] = $dbh->getMarche();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
}

require 'template/base.php';
?>
