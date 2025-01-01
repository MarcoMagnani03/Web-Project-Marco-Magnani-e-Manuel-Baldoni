<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Riepilogo Ordine e Pagamento";
$templateParams["nome"] = "checkout.php";
$templateParams["css"] = "checkout.css";

if(utenteLoggato()){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $templateParams["prodotti"] = $dbh->getProdottiCarrello($_SESSION["email"]);
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prodotti'])) {
        $prodotti = array_map('json_decode', $_POST['prodotti']);
        $templateParams["prodotti"] = $prodotti;
    }
}


require_once 'template/base.php';
?>