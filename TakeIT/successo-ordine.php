<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TakeIT - Ordine effettuato con successo";
$templateParams["nome"] = "messaggio-successo-ordine.php";
$templateParams["css"] = "checkout.css";

require_once 'template/base.php';
?>