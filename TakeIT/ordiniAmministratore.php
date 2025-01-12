<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordini";

//TODO fare la parte di lista ordini dell'amministratore, essendo molto simila a quello dell'utente si può valorizzare una valirabile templateParams["isAdmin"] a true e cambiare solo le cose necessarie

$templateParams["nome"] = "lista-ordini.php";
$templateParams["css"] = "ordini.css";

if($dbh->login_check_admin()){
	$filters = [
		"q" => $_GET["q"] ?? null,
		"ordine" => $_GET["ordine"] ?? null,
		"prezzo_min" => $_GET['prezzo_min'] ?? null,
		"prezzo_max" => $_GET['prezzo_max'] ?? null,
		"data_arrivo_min" => $_GET['data_arrivo_min'] ?? null,
		"data_arrivo_max" => $_GET['data_arrivo_max'] ?? null,
		"data_ordine_min" => $_GET['data_ordine_min'] ?? null,
		"data_ordine_max" => $_GET['data_ordine_max'] ?? null,
		"stato" => $_GET['stato'] ?? null
	];

    $templateParams["ordini"] = $dbh->getOrdini("", $filters);
    $templateParams["tipologie_ordini"] = $dbh->getTipologieOrdini();
	$templateParams["ordini_max_price"] = $dbh->getMaxPriceOfAllOrders();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvaOrdine'])) {
        $codiceOrdine = $_POST['codiceOrdine'];
        $dataOraArrivo = $_POST['dataOraArrivo'];
        $statoOrdine = $_POST['statoOrdine'];
        $utenteOrdine = $_POST["utenteOrdine"];
    
        if (!empty($codiceOrdine) && !empty($dataOraArrivo) && !empty($statoOrdine)) {
            $success = $dbh->modificaOrdine($codiceOrdine, $dataOraArrivo, $statoOrdine);
            $dbh->mandaNotificaAVenditore("Ordine modificato", "Modificato l'ordine n° $codiceOrdine, il nuovo stato è $statoOrdine");
            $dbh->aggiungiNotifica("Ordine modificato", "Modificato l'ordine n° $codiceOrdine, il nuovo stato è $statoOrdine", $utenteOrdine);

            if ($success) {
                echo "<p class='success'>Ordine #$codiceOrdine aggiornato con successo.</p>";
            } else {
                echo "<p class='error'>Errore durante l'aggiornamento dell'ordine #$codiceOrdine.</p>";
            }
        } else {
            echo "<p class='error'>Tutti i campi sono obbligatori.</p>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = intval($_POST["action"]);
        var_dump($action);
        if($action == 1){
            $codiceOrdine = $_POST["codiceOrdine"];
            $dbh->eliminaOrdine($codiceOrdine);
            $dbh->mandaNotificaAVenditore("Eliminato un ordine", "eliminato l'ordine con codice $codiceOrdine");
        }
    }
    
}
else{
    echo 'You are not authorized to access this page, please login. <br/>';
	header("Location: login.php");
}


require_once 'template/base.php';
?>