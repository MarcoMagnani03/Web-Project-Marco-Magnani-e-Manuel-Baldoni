<?php
require_once 'bootstrap.php';

if(utenteLoggato()) {
	//Base Template
	$templateParams["titolo"] = "TakeIT - Profilo";
	$templateParams["nome"] = "area-personale.php";

    $templateParams["css"] = "profilo.css";
	$templateParams["informazioni"] = $dbh->getInformazioni($_SESSION['email']);
    $_SESSION["utente_informazioni"] = $templateParams["informazioni"];

	require_once 'template/base.php';
} else {
	header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
}

require_once 'template/base.php';
?>