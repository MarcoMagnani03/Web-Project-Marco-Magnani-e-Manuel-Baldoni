<?php
require_once 'bootstrap.php';


if(utenteLoggato()){
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["prodotti"])) {
        $prodotti = $_POST["prodotti"];
        try {
            $dbh->aggiungiOrdine($prodotti);
        } catch (Exception $e) {
            throw($e);
        }
    
        $utente = $_SESSION["email"];
        $dettagliProdotti = "";
        foreach ($prodotti as $codiceProdotto => $datiProdotto) {
            $dettagliProdotti .= "Nome: " . htmlspecialchars($datiProdotto["nome"]) . ", Codice: " . htmlspecialchars($codiceProdotto) . "\n";
        }
        
        $notificaUtente = "Hai realizzato un ordine con i seguenti prodotti:\n" . $dettagliProdotti;
        $dbh->aggiungiNotifica("Realizzato ordine", $notificaUtente, $utente);
    
        $notificaVenditori = "L'utente $utente ha realizzato un ordine con i seguenti prodotti:\n" . $dettagliProdotti;
        $dbh->mandaNotificaAVenditore("Realizzato un ordine", $notificaVenditori);
    
        $dbh->svuotaCarrello($utente);
        header('Location: ./index.php');
    }
    
}
else{
    header('Location: ./login.php');
}

require_once 'template/base.php';
?>