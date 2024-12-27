<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Home";
$templateParams["nome"] = $dbh->login_check_admin() ? "lista-prodotti-amministratore.php" : "lista-prodotti.php";
$templateParams["css"] = $dbh->login_check_admin() ? "lista-prodotti-amministratore.css" : "lista-prodotti.css";

$templateParams["prodotti"] = $dbh->getProdotti();
$templateParams["tipologie_prodotti"] = $dbh->getTipologieProdotto();

$templateParams["prodotti"] = array_map(function($prodotto) use ($dbh) {
    $prodotto['immagine'] = $dbh->getImmaginePrincipaleProdotto($prodotto['codice']);
    return $prodotto;
}, $templateParams["prodotti"]);

require_once 'template/base.php';
?>