<?php
require_once 'bootstrap.php';

header('Content-Type: application/json');

$action = intval($_POST['action']); // 1 = Crea, 2 = Modifica, 3 = Elimina
try {
    switch ($action) {
        case 1:
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titolo = trim($_POST['titolo'] ?? '');
                
                if (empty($titolo)) {
                    echo json_encode(["success" => false, "message" => "Il titolo della marca è obbligatorio"]);
                    exit;
                }

                // Query per creare una nuova marca
                $dbh->creaNuovaMarca($titolo);
                $dbh->aggiungiNotifica("Creata nuova marca", "Creata una nuova marca con titolo: $titolo", $_SESSION['email']);
                echo json_encode(["success" => true, "message" => "Marca creata con successo"]);
                exit;
            }
            break;

        case 2: 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titolo = trim($_POST['titolo'] ?? '');
                $codice = trim($_POST['codice'] ?? '');

                if (empty($titolo)) {
                    echo json_encode(["success" => false, "message" => "Il titolo è obbligatorio"]);
                    exit;
                }

                // Query per modificare la marca
                $dbh->modificaMarca($codice, $titolo);
                $dbh->aggiungiNotifica("Modificata una marca", "Modificata la marca con codice: $codice e titolo: $titolo", $_SESSION['email']);
                echo json_encode(["success" => true, "message" => "Marca modificata con successo"]);
                exit;
            }
            break;

        case 3: 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $codice = trim($_POST['codice'] ?? '');

                if (empty($codice)) {
                    echo json_encode(["success" => false, "message" => "Il codice è obbligatorio"]);
                    exit;
                }

                // Query per eliminare la marca
                $dbh->eliminaMarca($codice);
                $dbh->aggiungiNotifica("Eliminata una marca", "Eliminata la marca con codice: $codice", $_SESSION['email']);
                echo json_encode(["success" => true, "message" => "Marca eliminata con successo"]);
                exit;
            }
            break;

        default:
            echo json_encode(["success" => false, "message" => "Azione non valida"]);
            exit;
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Errore: " . $e->getMessage()]);
    exit;
}
