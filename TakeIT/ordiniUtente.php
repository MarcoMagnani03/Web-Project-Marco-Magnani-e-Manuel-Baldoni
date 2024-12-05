<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";
$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

$templateParams["ordini"] = $dbh->getOrdini($_SESSION["email"]);
foreach ($templateParams["ordini"] as &$ordine) {
    $prezzoTotale = 0;
    foreach ($ordine['prodotti'] as $prodotto) {
        $prezzoTotale += $prodotto['prezzo'] * $prodotto['quantita'];
    }
    $ordine['prezzoTotale'] = $prezzoTotale;
}
unset($ordine);

require_once 'template/base.php';
?>