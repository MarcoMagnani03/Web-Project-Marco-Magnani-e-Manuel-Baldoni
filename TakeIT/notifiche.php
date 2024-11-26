<?php
require_once 'bootstrap.php';

sec_session_start();
if($dbh->login_check() == true) {
	//Base Template
	$templateParams["titolo"] = "TakeIT - Notifiche";
	$templateParams["nome"] = "centro-notifiche.php";

	if (!isset($_SESSION['email'])) {
		header("Location: login.php");
		exit;
	}

	$templateParams["notifiche"] = $dbh->getNotificheUtente($_SESSION['email']);

	require_once 'template/base.php';
} else {
	echo 'You are not authorized to access this page, please login. <br/>';
	header("Location: login.php");
}
?>