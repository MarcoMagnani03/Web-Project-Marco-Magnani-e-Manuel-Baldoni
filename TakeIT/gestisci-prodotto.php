<?php
require_once 'bootstrap.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if (!isset($_GET['action']) || !isset($_GET['codiceProdotto'])) {
        die('Parametri mancanti.');
    }
    
    $action = $_GET['action']; 
    $codice = $_GET['codiceProdotto'];   

    switch ($action) {
        case '1': 
            $prodotto = $dbh->getProdotto($codice);
            $prodotto["caratteristiche"] = $dbh->getSpecificheProdotto($codice);
            $immagini = $dbh->getImmaginiProdotto($codice);
            $templateParams["tipologie_prodotti"] = $dbh->getTipologieProdotto("");
            $templateParams["marche"] = $dbh->getMarche();
    
            for($i=0;$i<count($immagini);$i++){
                $immagini[$i] = $immagini[$i];
            }
    
            $templateParams["immagini_prodotto"] = $immagini;
    
            if (!$prodotto) {
                die('Prodotto non trovato.');
            }
    
            $templateParams["titolo"] = "TakeIT - Modifica prodotto";
            $templateParams["nome"] = "nuovo-prodotto-form.php";
            $templateParams["css"] = "nuovo-prodotto.css";
            $templateParams["prodotto"] = $prodotto;
            break;
    
        case '2': 
            $result = $dbh->eliminaProdotto($codice);
            if ($result) {
                $dbh->aggiungiNotifica("Eliminato un prodotto", "Eliminato il prodotto di codice: $codice", $_SESSION["email"]);
                header("Location: index.php");
                exit();
            } else {
                die('Errore durante l\'eliminazione del prodotto.');
            }
            break;
    
        default:
            die('Azione non valida.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['action']) && $_POST['action'] == 2){
		$products = $_POST['products'];
                    
		// Itera su ogni prodotto inviato
		foreach ($products as $product) {
			$codice = isset($product['codiceProdotto']) ? $product['codiceProdotto'] : 0;
			$quantita = isset($product['quantita']) ? (int)$product['quantita'] : 0;

			if (!empty($codice) && $quantita > 0) {
				$dbh->aggiornaQuantitaProdotto($codice, $quantita);
			}
		}
		echo json_encode(["success" => true, "message" => "Modifica avvenuta con successo al carrello"]);
	}
	else{
		$codice = isset($_POST['codice']) ? trim($_POST['codice']) : "";
		$nome = isset($_POST['nome']) ? trim($_POST['nome']) : "";
		$descrizione = isset($_POST['descrizione']) ? trim($_POST['descrizione']) : "";
		$prezzo = isset($_POST['prezzo']) ? floatval($_POST['prezzo']) : -1;
		$quantita = isset($_POST['quantita']) ? intval($_POST['quantita']) : -1;
		$tipologia = isset($_POST['tipologia']) ? $_POST['tipologia'] : "";
		$disponibile = isset($_POST['disponibile']) ? "disponibile" : "non disponibile";
		$marca = isset($_POST['marche']) ? intval($_POST['marche']) : "";

		
		if (isset($_POST['immagini_da_rimuovere'])) {
			$immaginiDaRimuovere = explode(',', $_POST['immagini_da_rimuovere']);
			$dbh->eliminaImmaginiProdotto($immaginiDaRimuovere);
			foreach ($immaginiDaRimuovere as $percorsoImmagine) {
				if (file_exists($percorsoImmagine)) {
					unlink($percorsoImmagine); 
				}
			}
		}

		if (!empty($_POST['caratteristiche'])) {
			$dbh->modificaSpecificheProdotto($codice, $_POST['caratteristiche']);
		}

		// Aggiorna immagine solo se caricata
		if (!empty($_FILES['foto']) && count($_FILES['foto']['name']) > 0) {
			foreach ($_FILES['foto']['name'] as $index => $name) {
				if ($_FILES['foto']['error'][$index] === UPLOAD_ERR_OK) {
					$tmpName = $_FILES['foto']['tmp_name'][$index];
					$file = [
						"name" => $name,
						"type" => $_FILES['foto']['type'][$index],
						"size" => $_FILES['foto']['size'][$index],
						"tmp_name" => $tmpName
					];

					list($result, $msg) = uploadImage(UPLOAD_DIR, $file);

					if ($result === 1) {
						if($dbh->inserisciImmagineProdotto($codice, $msg) == false){    
							unlink($msg);
							throw new Exception("Errore durante il caricamento di un'immagine: $msg");
						}
					} else {
						throw new Exception("Errore durante il caricamento di un'immagine: $msg");
					}
				}
			}
		}

		// Aggiorna i dettagli del prodotto
		$result = $dbh->modificaProdotto($codice, $nome, $descrizione, $prezzo, $quantita, $tipologia, $disponibile, $marca);
		
		if ($result) {
			$dbh->aggiungiNotifica("Modificato prodotto", "Modificato il prodotto di codice $codice", $_SESSION["email"]);
			header("Location: index.php");
			exit();
		} else {
			die('Errore durante l\'aggiornamento del prodotto.');
		}
	}
}

require 'template/base.php';
?>
