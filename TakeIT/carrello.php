<?php
require_once 'bootstrap.php';

if(utenteLoggato()){

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        header('Content-Type: application/json');
        
        $prodotti_carrello = $dbh->getProdottiCarrello($_SESSION["email"]);
        
        echo json_encode(array_map(function($prodotto) {
            return [
                "immagine" => htmlspecialchars($prodotto["immagine"]),
                "nome" => htmlspecialchars($prodotto["nome"]),
                "prezzo" => htmlspecialchars($prodotto["prezzo"]),
                "quantita" => htmlspecialchars($prodotto["quantita"]),
            ];
        }, $prodotti_carrello));
    }
    else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){
        $action = intval($_POST['action']);
        switch($action){
            case 1:
                $codice = $_POST['codice']; 
                if (empty($codice)) {
                    echo json_encode(["success" => false, "message" => "Il codice del prodotto non è presente"]);
                    exit;
                }
                if(!$dbh->aggiungiProdottoCarrello($codice, $_SESSION["email"])){
                    echo json_encode(["success" => false, "message" => "errore durante l'aggiunta del prodotto al carrello"]);
                    exit;
                }
                $dbh->aggiungiNotifica("Aggiunto un prodotto al carrello", "Aggiunto il prodotto $codice al carrello", $_SESSION["email"]);
                echo json_encode(["success" => true, "message" => "Prodotto aggiunto con successo"]);
                break;
        }

    }
}

?> 