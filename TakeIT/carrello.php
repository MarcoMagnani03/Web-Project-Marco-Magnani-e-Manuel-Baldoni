<?php
require_once 'bootstrap.php';

if(utenteLoggato()){

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        header('Content-Type: application/json');
        
        $prodotti_carrello = $dbh->getProdottiCarrello($_SESSION["email"]);
        
        echo json_encode(array_map(function($prodotto) {
            return [
                "codice" => htmlspecialchars($prodotto["codice"]),
                "immagine" => htmlspecialchars($prodotto["immagine"]),
                "nome" => htmlspecialchars($prodotto["nome"]),
                "prezzo" => htmlspecialchars($prodotto["prezzo"]),
                "quantita" => htmlspecialchars($prodotto["quantita"]),
            ];
        }, $prodotti_carrello));
    }
    else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){
        $action = intval($_POST['action']); // 1 -> aggiunta al carrello, 2-> modifica quantità , 3-> eliminazione
        switch($action){
            case 1:
                $codice = isset($_POST['codice']) ? $_POST['codice'] : ""; 
                if (empty($codice)) {
                    echo json_encode(["success" => false, "message" => "Il codice del prodotto non è presente"]);
                    exit;
                }
                $dbh->aggiungiProdottoCarrello($codice, $_SESSION["email"]);
                $dbh->aggiungiNotifica("Aggiunto un prodotto al carrello", "Aggiunto il prodotto $codice al carrello", $_SESSION["email"]);
                echo json_encode(["success" => true, "message" => "Prodotto aggiunto con successo"]);
                break;
            case 2:
                if (isset($_POST['products']) && is_array($_POST['products'])) {
                    $products = $_POST['products'];
                    
                    // Itera su ogni prodotto inviato
                    foreach ($products as $product) {
                        $codice = isset($product['codiceProdotto']) ? $product['codiceProdotto'] : 0;
                        $quantita = isset($product['quantita']) ? (int)$product['quantita'] : 0;
            
                        if (!empty($codice) && $quantita > 0) {
                            $dbh->aggiornaQuantitaProdottoCarrello($codice, $quantita, $_SESSION["email"]);
                            $dbh->aggiungiNotifica("Aggiornata quantità prodotto al carrello", "Aggiornata la quantità del prodotto di codice: $codice al carrello, nuova quantità: $quantita", $_SESSION["email"]);
                        }
                    }
                    echo json_encode(["success" => true, "message" => "Modifica avvenuta con successo al carrello"]);
                }
                break;
            case 3:
                if (isset($_POST['prodotti']) && is_array($_POST['prodotti'])) {
                    $products = $_POST['prodotti'];
                    
                    // Itera su ogni prodotto inviato
                    foreach ($products as $product) {
                        $codice = isset($product['codiceProdotto']) ? $product['codiceProdotto'] : 0;
                        $quantita = isset($product['quantita']) ? (int)$product['quantita'] : 0;
            
                        if (!empty($codice) && $quantita > 0) {
                            $dbh->eliminaProdottoCarrello($codice, $_SESSION["email"]);
                            $dbh->aggiungiNotifica("Eliminato un prodotto dal carrello", "Eliminato dal carrello il prodotto di codice: $codice", $_SESSION["email"]);
                        }
                    }
                    echo json_encode(["success" => true, "message" => "Modifica avvenuta con successo al carrello"]);
                }
                break;
        }

    }
}

?> 