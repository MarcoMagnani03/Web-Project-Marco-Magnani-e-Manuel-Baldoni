<?php
	require_once 'bootstrap.php';

	if($dbh->login_check_admin()) {
		//Base Template
		$templateParams["titolo"] = "TakeIT - Marche";
		$templateParams["nome"] = "lista-marche.php";
		$templateParams["css"] = "marche.css";

		$templateParams["marche"] = $dbh->getMarche();

		require_once 'template/base.php';
	} else {
		echo 'You are not authorized to access this page, please login. <br/>';
		header("Location: login.php");
	}
?>