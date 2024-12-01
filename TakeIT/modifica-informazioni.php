<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Modifica Informazioni";
$templateParams["nome"] = "modifica-informazioni-form.php";

if (!isset($_SESSION["utente_informazioni"])) {
    $templateParams["informazioni"] = $dbh->getInformazioni($_SESSION["email"]);
    $_SESSION["utente_informazioni"] = $templateParams["informazioni"];
} else {
    $templateParams["informazioni"] = $_SESSION["utente_informazioni"];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $confermaPassword = isset($_POST['confermaPassword']) ? $_POST['confermaPassword'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : null;
    $dataDiNascita = isset($_POST['dataDiNascita']) ? $_POST['dataDiNascita'] : null;
    
    $result = $dbh->modificaInformazioni($email, $password, $nome, $cognome, $dataDiNascita);
    header('Location: ./profilo.php');
}

require 'template/base-login.php';
?>
