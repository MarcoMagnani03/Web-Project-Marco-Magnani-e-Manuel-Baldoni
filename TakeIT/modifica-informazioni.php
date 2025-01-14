<?php
require_once 'bootstrap.php';

if(utenteLoggato()){
	$templateParams["titolo"] = "TakeIT - Modifica Informazioni";
	$templateParams["nome"] = "modifica-informazioni-form.php";
	
	$templateParams["css"] = "modifica-utente.css";
	
	if (!isset($_SESSION["utente_informazioni"])) {
		$templateParams["informazioni"] = $dbh->getInformazioni($_SESSION["email"]);
		$_SESSION["utente_informazioni"] = $templateParams["informazioni"];
	} else {
		$templateParams["informazioni"] = $_SESSION["utente_informazioni"];
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$action = isset($_POST['action']) ? $_POST['action'] : null;
	
		if ($action === "ottieniVecchiaPassword" && isset($_POST['email'])) {
			header('Content-Type: application/json');
			$email = $_POST['email'];
			$passwordData = $dbh->getPasswordData($email);
			echo json_encode($passwordData);
			exit;
		} elseif ($action === "modificaInformazioni") {
			$email = isset($_POST['email']) ? $_POST["email"] : null;
			$password = isset($_POST['password']) ? $_POST['password'] : null;
			$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
			$cognome = isset($_POST['cognome']) ? $_POST['cognome'] : null;
			$dataDiNascita = isset($_POST['dataDiNascita']) ? $_POST['dataDiNascita'] : null;
	
			if (!$email || !$password || !$nome || !$cognome || !$dataDiNascita) {
				echo json_encode(["success" => false, "message" => "Dati mancanti"]);
				exit;
			}
	
			$result = $dbh->modificaInformazioni($email, $password, $nome, $cognome, $dataDiNascita);
	
			if ($result) {
				echo json_encode(["success" => true, "message" => "Informazioni aggiornate con successo"]);
			} else {
				echo json_encode(["success" => false, "message" => "Errore durante l'aggiornamento delle informazioni"]);
			}
			exit;
		}
	}
	
	require 'template/base.php';
} else {
	header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
}

?>
