<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Login";
$templateParams["nome"] = "login-form.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $utente = $dbh->login($email, $password);

    if ($utente) {
        $_SESSION['utente'] = $utente['email'];
        $templateParams["utente"] = $utente;
        $templateParams["errorelogin"] = "accesso con ".$utente["email"];
    } else {
        $templateParams["errorelogin"] = "Credenziali errate. Riprova.";
    }
}


require 'template/base-login.php';
?>