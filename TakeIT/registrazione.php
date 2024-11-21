<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Registrazione";
$templateParams["nome"] = "registrazione-form.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $dataDiNascita = $_POST['dataDiNascita'];

    $result = $dbh->registrazione($email, $password, $nome, $cognome, $dataDiNascita);

    if ($result === true) {
        
    } elseif ($result === "L'email è già registrata") {
        $templateParams["erroreregistrazione"] = "L'email inserita è già associata a un account.";
    } else {
        $templateParams["erroreregistrazione"] = "Errore durante la registrazione. Riprova più tardi.";
    }
}

require 'template/base-login.php';
?>
