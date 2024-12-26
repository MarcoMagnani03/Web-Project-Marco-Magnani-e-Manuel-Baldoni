<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";

//TODO fare la parte di lista ordini dell'amministratore, essendo molto simila a quello dell'utente si può valorizzare una valirabile templateParams["isAdmin"] a true e cambiare solo le cose necessarie

$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

if($dbh->login_check_admin()){
    $templateParams["ordini"] = $dbh->getTuttiOrdini();
    $templateParams["tipologie_ordini"] = $dbh->getTipologieOrdini();
    foreach ($templateParams["ordini"] as &$ordine) {
        $prezzoTotale = 0;
        foreach ($ordine['prodotti'] as $prodotto) {
            $prezzoTotale += $prodotto['prezzo'] * $prodotto['quantita'];
        }
        $ordine['prezzoTotale'] = $prezzoTotale;
    }
    unset($ordine);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvaOrdine'])) {
        $codiceOrdine = $_POST['codiceOrdine'];
        $dataOraArrivo = $_POST['dataOraArrivo'];
        $statoOrdine = $_POST['statoOrdine'];
    
        if (!empty($codiceOrdine) && !empty($dataOraArrivo) && !empty($statoOrdine)) {
            $success = $dbh->modificaOrdine($codiceOrdine, $dataOraArrivo, $statoOrdine);
            $dbh->aggiungiNotifica("Ordine modificato", "Modificato l'ordine n° $codiceOrdine",$_SESSION['email']);
    
            if ($success) {
                echo "<p class='success'>Ordine #$codiceOrdine aggiornato con successo.</p>";
            } else {
                echo "<p class='error'>Errore durante l'aggiornamento dell'ordine #$codiceOrdine.</p>";
            }
        } else {
            echo "<p class='error'>Tutti i campi sono obbligatori.</p>";
        }
    }
    
}
else{
    echo 'You are not authorized to access this page, please login. <br/>';
	header("Location: login.php");
}


require_once 'template/base.php';
?>