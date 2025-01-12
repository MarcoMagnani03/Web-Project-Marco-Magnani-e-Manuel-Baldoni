<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Nuovo prodotto";
$templateParams["nome"] = "nuovo-prodotto-form.php";
$templateParams["css"] = "nuovo-prodotto.css";
$templateParams["errorenuovoprodotto"] = "";

$templateParams["tipologie_prodotti"] = $dbh->getTipologieProdotto("");
$templateParams["marche"] = $dbh->getMarche("");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tipo'])) {
    header('Content-Type: application/json');
    $tipo = $_GET['tipo'];

    $caratteristiche = $dbh->getCaratteristichePerTipologia($tipo);

    echo json_encode($caratteristiche);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = isset($_POST['nome']) ? trim($_POST['nome']) : "";
        $descrizione = isset($_POST['descrizione']) ? trim($_POST['descrizione']) : "";
        $prezzo = isset($_POST['prezzo']) ? floatval($_POST['prezzo']) : -1;
        $quantita = isset($_POST['quantita']) ? intval($_POST['quantita']) : -1;
        $tipologia = isset($_POST['tipologia']) ? $_POST['tipologia'] : "";
        $disponibile = isset($_POST['disponibile']) ? "disponibile" : "non disponibile";
        $marca = isset($_POST['marche']) ? intval($_POST['marche']) : "";



        if (empty($nome) || $prezzo <= 0 || $quantita < 0 || empty($tipologia)) {
            throw new Exception("Compila tutti i campi obbligatori.");
        }

        $codiceProdotto = $dbh->inserisciProdotto($nome, $descrizione, $prezzo, $quantita, $tipologia, $marca, $disponibile);

        if (!empty($_POST['caratteristiche'])) {
            foreach ($_POST['caratteristiche'] as $codice => $valore) {
                $dbh->inserisciSpecificaProdotto($codiceProdotto, $codice, trim($valore));
            }
        }

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
                        // Inserisci immagine nel database
                        $dbh->inserisciImmagineProdotto($codiceProdotto, $msg);
                    } else {
                        throw new Exception("Errore durante il caricamento di un'immagine: $msg");
                    }
                }
            }
        }
        
        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        $templateParams["errorenuovoprodotto"] = $e->getMessage();
    }
}


require 'template/base.php';
?>
