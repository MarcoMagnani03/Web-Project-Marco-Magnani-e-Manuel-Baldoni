<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Notifiche";
$templateParams["nome"] = "centro-notifiche.php";

if (!isset($_SESSION['utente'])) {
    header("Location: login.php");
    exit;
}

$templateParams["notifiche"] = $dbh->getNotificheUtente($_SESSION['utente']);

require_once 'template/base.php';
?>