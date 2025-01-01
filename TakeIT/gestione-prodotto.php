<?php
require_once 'database.php'; 

if (!isset($_GET['action']) || !isset($_GET['id'])) {
    die('Parametri mancanti.');
}

$action = $_GET['action']; 
$id = $_GET['codiceProdotto'];         

switch ($action) {
    case '1': 
        $prodotto = $dbh->getProdotto($id);
        if (!$prodotto) {
            die('Prodotto non trovato.');
        }

        $templateParams["titolo"] = "TakeIT - Modifica prodotto";
        $templateParams["nome"] = "modifica-prodotto-form.php";
        $templateParams["css"] = "modifica-prodotto.css";
        $templateParams["prodotto"] = $prodotto;
        break;

    case '2': 
        $result = $dbh->deleteProdotto($id);
        if ($result) {
            //aggiungere logica con ?msg=Prodotto eliminato con successo.
            header("Location: index.php");
            exit();
        } else {
            die('Errore durante l\'eliminazione del prodotto.');
        }
        break;

    default:
        die('Azione non valida.');
}

//TODO: Sotto c'è la logica per quando si fa il submit del prodotto modificato, va ancora creato il form

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] == '1') {
//     $id = $_GET['id'];
//     $nome = $_POST['nome'];
//     $descrizione = $_POST['descrizione'];
//     $prezzo = $_POST['prezzo'];
//     $immagine = $_FILES['immagine'];

//     // Validazione base
//     if (empty($nome) || empty($descrizione) || empty($prezzo)) {
//         die('Tutti i campi richiesti devono essere compilati.');
//     }

//     // Aggiorna immagine solo se caricata
//     if (!empty($immagine['name'])) {
//         $uploadDir = 'uploads/';
//         $filePath = $uploadDir . basename($immagine['name']);

//         // Controlla che il file sia un'immagine valida
//         $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
//         if (!in_array($immagine['type'], $allowedTypes)) {
//             die('Formato immagine non supportato.');
//         }

//         // Sposta il file nella directory di upload
//         if (!move_uploaded_file($immagine['tmp_name'], $filePath)) {
//             die('Errore durante il caricamento dell\'immagine.');
//         }

//         // Aggiorna il percorso dell'immagine nel database
//         $dbh->updateProdottoImmagine($id, $filePath);
//     }

//     // Aggiorna i dettagli del prodotto
//     $result = $dbh->updateProdotto($id, $nome, $descrizione, $prezzo);

//     if ($result) {
//         header("Location: lista-prodotti.php?msg=Prodotto aggiornato con successo.");
//         exit();
//     } else {
//         die('Errore durante l\'aggiornamento del prodotto.');
//     }
// }

require 'template/base.php';
?>
