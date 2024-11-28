<?php
require_once 'bootstrap.php';

if($dbh->login_check() == true) {
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

	require_once 'template/base.php';
} else {
	echo 'You are not authorized to access this page, please login. <br/>';
	header("Location: login.php");
}
?>