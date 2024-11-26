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
    $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : null;
    $dataDiNascita = isset($_POST['dataDiNascita']) ? $_POST['dataDiNascita'] : null;

    $result = $dbh->registrazione($email, $password, $nome, $cognome, $dataDiNascita);

    if ($result === true) {
        $templateParams["messaggio"] = "Registrazione completata con successo!";
    } elseif ($result === "L'email è già registrata") {
        $templateParams["erroreregistrazione"] = "L'email inserita è già associata a un account.";
    } else {
        $templateParams["erroreregistrazione"] = "Errore durante la registrazione. Riprova più tardi.";
    }
}

require 'template/base-login.php';
?>
