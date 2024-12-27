<?php
require_once 'bootstrap.php';

// Controlla se l'azione è impostata
if (!isset($_GET['action'])) {
    die("Azione non valnomea.");
}

$action = intval($_GET['action']); // 1 = Crea, 2 = Modifica, 3 = Elimina
switch ($action) {
    case 1: // Crea una nuova tipologia
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descrizione = trim($_POST['descrizione'] ?? '');
            $caratteristiche = $_POST['caratteristiche'];
            
            if (empty($nome) || empty($descrizione)) {
                $error = "Nome e descrizione sono obbligatori.";
            } else {
                // Query per creare una nuova tipologia
                $dbh->creaNuovaTipologia($nome, $descrizione);
                $dbh->aggiungiCaratteristiche($nome,$caratteristiche);
                $dbh->aggiungiNotifica("Creata nuova tipologia prodotto","Creata tipologia prodotto con nome: $nome",$_SESSION['email']);
                header("Location: tipologie-prodotto.php"  );
                exit;
            }
        }
        else{
            $templateParams["titolo"] = "TakeIT - Modifica tipologia prodotto";
            $templateParams["nome"] = "modifica-tipologia-prodotto-form.php";
            $templateParams["css"] = "modifica-tipologia.css";
            $templateParams["action"] = "1";
            require_once 'template/base.php';
        }
        break;

    case 2: 
        if (!isset($_GET['nome'])) {
            die("nome tipologia non specificato.");
        }

        $nome = $_GET['nome'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descrizione = trim($_POST['descrizione'] ?? '');
            $caratteristiche = $_POST['caratteristiche'];
            
            if (empty($nome))  {
                $error = "Nome è obbligatorio.";
            } else {
                // Query per aggiornare la tipologia
                $dbh->updateTipologia($nome, $descrizione, $caratteristiche);
                $dbh->aggiungiNotifica("Modificata tipologia prodotto","Modificata tipologia prodotto con nome: $nome",$_SESSION['email']);
                header("Location: tipologie-prodotto.php");
                exit;
            }
        } else {
            // Recupera i dati della tipologia per precompilare il form
            $tipologia = $dbh->getTipologiaBynome($nome);
            if (!$tipologia) {
                echo $nome;
                die("Tipologia non trovata.");
            }
            $templateParams["titolo"] = "TakeIT - Modifica tipologia prodotto";
            $templateParams["nome"] = "modifica-tipologia-prodotto-form.php";
            $templateParams["css"] = "modifica-tipologia.css";
            $templateParams["action"] = 2;
            $templateParams["tipologia"] = $tipologia;
            require_once 'template/base.php';
        }
        break;

    case 3: 
        if (!isset($_GET['nome'])) {
            die("nome tipologia non specificato.");
        }

        $nome = $_GET['nome'];
        $dbh->deleteTipologia($nome);
        $dbh->aggiungiNotifica("Eliminazione tipologia prodotto","Eliminata tipologia con nome: $nome",$_SESSION['email']);
        header("Location: tipologie-prodotto.php"  );
        exit;

    default:
        die("Azione non valida.");
}
