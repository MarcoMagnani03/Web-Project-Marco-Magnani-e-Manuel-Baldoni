<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";

//TODO fare la parte di lista ordini dell'amministratore, essendo molto simila a quello dell'utente si può valorizzare una valirabile templateParams["isAdmin"] a true e cambiare solo le cose necessarie

$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

if($dbh->login_check_admin()){
    $templateParams["ordini"] = $dbh->getTuttiOrdini();
    foreach ($templateParams["ordini"] as &$ordine) {
        $prezzoTotale = 0;
        foreach ($ordine['prodotti'] as $prodotto) {
            $prezzoTotale += $prodotto['prezzo'] * $prodotto['quantita'];
        }
        $ordine['prezzoTotale'] = $prezzoTotale;
    }
    unset($ordine);
}
else{
    echo 'You are not authorized to access this page, please login. <br/>';
	header("Location: login.php");
}


require_once 'template/base.php';
?>