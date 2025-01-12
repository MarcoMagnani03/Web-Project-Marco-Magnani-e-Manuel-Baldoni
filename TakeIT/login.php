<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Login";
$templateParams["nome"] = "login-form.php";

sec_session_start(); 

if(isset($_POST['email'], $_POST['p'])) { 
   $email = $_POST['email'];
   $password = $_POST['p']; // Recupero la password criptata.
   if($dbh->login($email, $password) == true) {
      header('Location: ./index.php');
   }
   else{
	header('Location: ./login.php?notifica_type=error&notifica_message=' . urlencode("Email o password errati"));
   }
}

if(utenteLoggato()){
   header('Location: ./index.php');
}

require 'template/base-login.php';
?>