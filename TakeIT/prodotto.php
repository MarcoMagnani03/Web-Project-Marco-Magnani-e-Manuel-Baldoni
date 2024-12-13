<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Prodotto";
$templateParams["nome"] = "single-prodotto.php";
$templateParams["css"] = "single-prodotto.css";

$codiceProdotto = -1;
if(isset($_GET["codice"])){
    $codiceProdotto = $_GET['codice'];
}
var_dump($codiceProdotto);
$templateParams["prodotto"] = $dbh->getProdotto($codiceProdotto);

var_dump($templateParams["prodotto"]);

$templateParams["valutazione_prodotto"] = $dbh->getValutazioneForProdotto($codiceProdotto);
$templateParams["specifiche_prodotto"] = $dbh->getSpecificheProdotto($codiceProdotto);
$templateParams["recensioni_prodotto"] = $dbh->getRecensioniForProdotto($codiceProdotto);
$templateParams["prodotti_correlati"] = $dbh->getProdottiCorrelati($codiceProdotto, $templateParams["prodotto"]["tipologia"]);

$templateParams["immagini_prodotto"] = $dbh->getImmaginiProdotto($templateParams["prodotto"]["codice"]);

var_dump($templateParams["immagini_prodotto"]);

require_once 'template/base.php';
?>