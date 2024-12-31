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
        // DA LISTA ORDINI FACCIO UNA POST CON I PRODOTTI
        foreach ($prodotti as $prodotto) {
            // QUI CI SONO TUTTI I PRODOTTI PUOI FARLO ANCHE DAL CARRELLO PASSANDO I PRODOTTI TENENDO UN FORM HIDDEN
            // (nel caso guarda come ho fatto per lista ordini), PUOI VALORIZZARE TEMPLATEPARAMS, non ha tanto senso usare AJAX per questo
        }
    }
}


require_once 'template/base.php';
?>