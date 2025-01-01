<?php
require_once 'bootstrap.php'; 

// Controlla se l'azione è impostata
if (!isset($_GET['action'])) {
    die("Azione non valnomea.");
}

$action = intval($_GET['action']);
switch ($action) {
    case '1':
		$valutazione_recensione = $_POST['valutazione'];
		$titolo_recensione = $_POST['titolo'];
		$descrizione_recensione = $_POST['descrizione'];
		$codice_prodotto = $_POST['codice_prodotto'];
		$email_utente = $_SESSION['email'];

		$dbh->creaNuovaRecensione($valutazione_recensione, $titolo_recensione, $descrizione_recensione, $codice_prodotto, $email_utente);
        $dbh->aggiungiNotifica("Creata nuova recensione","Creata nuova recensione per il prodotto: ".$codice_prodotto,$_SESSION['email']);
		header("Location: prodotto.php?codice=".$codice_prodotto."&notifica_type=success&notifica_message=Recensione creata con successo"  );
		break;

    case '2':
        
        break;

    default:
        die('Azione non valida.');
}

require_once 'template/base.php';
?>
