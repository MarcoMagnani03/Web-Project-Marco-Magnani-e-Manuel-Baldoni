<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Riepilogo Ordine e Pagamento";
$templateParams["nome"] = "checkout.php";
$templateParams["css"] = "checkout.css";

if(utenteLoggato()){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $templateParams["prodotti"] = $dbh->getProdottiCarrello($_SESSION["email"]);

		if(count($templateParams["prodotti"]) == 0){
			header("Location: index.php?notifica_type=error&notifica_message=" . urlencode("Non ci sono abbastanza prodotti nel carrello"));
		}
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prodotti'])) {
        $prodotti = array_map('json_decode', $_POST['prodotti']);
        $templateParams["prodotti"] = $prodotti;
    }
} else{
	header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
}

require_once 'template/base.php';
?>