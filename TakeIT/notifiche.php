<?php
require_once 'bootstrap.php';

if(utenteLoggato()) {
	//Base Template
	$templateParams["titolo"] = "TakeIT - Notifiche";
	$templateParams["nome"] = "centro-notifiche.php";

	$input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['notificaIds']) && is_array($data['notificaIds'])) {
		$dbh->aggiornaNotificheLette($data['notificaIds']);
	}

    $templateParams["css"] = "notifiche.css";
	$templateParams["notifiche"] = $dbh->getNotificheUtente($_SESSION['email']);

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = intval($_POST["action"]);
		if($action == 1){
			$dbh->eliminaNotifica($_POST["codiceNotifica"]);
		}
    }

	require_once 'template/base.php';
} else {
	header("Location: login.php?notifica_type=error&notifica_message=" . urlencode("Devi essere loggato per accedere alla pagina"));
}
?>