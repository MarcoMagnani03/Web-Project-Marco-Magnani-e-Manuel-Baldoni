<?php
require_once 'bootstrap.php';


if(utenteLoggato()){

    $action = $_GET['action']; 
    
    if($_SERVER['REQUEST_METHOD'] === 'GET' && $action == "1"){
        //$dbh->aggiungiOrdine(); Creare metodo di aggiunta
        $dbh->svuotaCarrello($_SESSION["email"]);
        header('Location: ./index.php');
        //TODO-> Fare notifica
    }
}
else{
    header('Location: ./login.php');
}

require_once 'template/base.php';
?>