<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Registrazione";
$templateParams["nome"] = "registrazione-form.php";
$templateParams["erroreregistrazione"] = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $confermaPassword = isset($_POST['confermaPassword']) ? $_POST['confermaPassword'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $cellulare = isset($_POST['cellulare']) ? $_POST['cellulare'] : null;
    $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : null;
    $dataDiNascita = isset($_POST['dataDiNascita']) ? $_POST['dataDiNascita'] : null;

    $result = $dbh->registrazione($email, $password, $nome, $cognome, $cellulare, $dataDiNascita);

    if ($result === true) {
        header('Location: ./login.php?notifica_type=success&notifica_message=' . urlencode("Registrazione avvenuta con successo!"));
    } elseif ($result === "L'email è già registrata") {
		header('Location: ./registrazione.php?notifica_type=error&notifica_message=' . urlencode("L'email inserita è già associata a un account."));
        $templateParams["erroreregistrazione"] = "L'email inserita è già associata a un account.";
    } else {
		header('Location: ./registrazione.php?notifica_type=error&notifica_message=' . urlencode("Errore durante la registrazione. Riprova più tardi."));
        $templateParams["erroreregistrazione"] = "Errore durante la registrazione. Riprova più tardi.";
    }
}

require 'template/base-login.php';
?>
