<?php
require_once 'bootstrap.php';

if($dbh->login_check() == true) {
	//Base Template
	$templateParams["titolo"] = "TakeIT - Profilo";
	$templateParams["nome"] = "area-personale.php";

    $templateParams["css"] = "profilo.css";
	$templateParams["campi_utente"] = $dbh->getInformazioni($_SESSION['email']);

	require_once 'template/base.php';
} else {
	echo 'You are not authorized to access this page, please login. <br/>';
	header("Location: login.php");
}
?>