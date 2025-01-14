<?php
	require_once 'bootstrap.php';

	if(utenteLoggato()){
		if($dbh->login_check_admin()) {
			//Base Template
			$templateParams["titolo"] = "TakeIT - Tipologie prodotto";
			$templateParams["nome"] = "lista-tipologie-prodotto.php";
			$templateParams["css"] = "tipologie-prodotto.css";
	
			$templateParams["tipologie_prodotto"] = $dbh->getTipologieProdotto($_GET["q"] ?? "");
	
			require_once 'template/base.php';
		} else {
			header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere amministratore per accedere alla pagina"));
		}
	} else {
		header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
	}
?>