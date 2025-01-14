<?php
	require_once 'bootstrap.php';

	if(utenteLoggato()){
		if($dbh->login_check_admin()) {
			//Base Template
			$templateParams["titolo"] = "TakeIT - Marche";
			$templateParams["nome"] = "lista-marche.php";
			$templateParams["css"] = "marche.css";
	
			$templateParams["marche"] = $dbh->getMarche($_GET["q"] ?? "");
	
			require_once 'template/base.php';
		} else {
			header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere amministratore per accedere alla pagina"));
		}
	} else {
		header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
	}
?>