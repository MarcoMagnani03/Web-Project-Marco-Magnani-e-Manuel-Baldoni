<?php
	require_once 'bootstrap.php';

	if($dbh->login_check_admin()) {
		//Base Template
		$templateParams["titolo"] = "TakeIT - Tipologie prodotto";
		$templateParams["nome"] = "lista-tipologie-prodotto.php";
		$templateParams["css"] = "tipologie-prodotto.css";

		$templateParams["tipologie_prodotto"] = $dbh->getTipologieProdotto($_GET["q"] ?? "");

		require_once 'template/base.php';
	} else {
		echo 'You are not authorized to access this page, please login. <br/>';
		header("Location: login.php");
	}
?>