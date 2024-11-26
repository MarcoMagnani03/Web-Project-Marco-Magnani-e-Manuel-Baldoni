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
$templateParams["prodotto"] = $dbh->getProdotto($codiceProdotto);

$templateParams["specifiche_prodotto"] = $dbh->getSpecificheProdotto($codiceProdotto);
$templateParams["recensioni_prodotto"] = $dbh->getRecensioniForProdotto($codiceProdotto);

require_once 'template/base.php';
?>