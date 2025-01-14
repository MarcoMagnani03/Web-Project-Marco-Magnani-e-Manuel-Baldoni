<?php
require_once 'bootstrap.php';

if(utenteLoggato()){
	//Base Template
	$templateParams["titolo"] = "TakeIT - Home";
	$templateParams["nome"] = $dbh->login_check_admin() ? "lista-prodotti-amministratore.php" : "lista-prodotti.php";
	$templateParams["css"] = $dbh->login_check_admin() ? "lista-prodotti-amministratore.css" : "lista-prodotti.css";

	$filters = [
		"q" => $_GET["q"] ?? null,
		"ordine" => $_GET["ordine"] ?? null,
		"tipologie_prodotto" => $_GET["tipologie_prodotto"] ?? null,
		"marche" => $_GET["marche"] ?? null,
		"recensioni" => $_GET['recensioni'] ?? null,
		"prezzo_min" => $_GET['prezzo_min'] ?? null,
		"prezzo_max" => $_GET['prezzo_max'] ?? null
	];

	$templateParams["prodotti"] = $dbh->getProdotti($filters);
	$templateParams["prodotti_max_price"] = $dbh->getMaxPriceOfProducts();
	$templateParams["tipologie_prodotto"] = $dbh->getTipologieProdotto("");
	$templateParams["marche"] = $dbh->getMarche("");

	$templateParams["prodotti"] = array_map(function($prodotto) use ($dbh) {
		$prodotto['immagine'] = $dbh->getImmaginePrincipaleProdotto($prodotto['codice']);
		return $prodotto;
	}, $templateParams["prodotti"]);

	require_once 'template/base.php';
} else {
	header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
}

?>