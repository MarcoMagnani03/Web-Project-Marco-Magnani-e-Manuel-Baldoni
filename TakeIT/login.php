<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TakeIT - Login";
$templateParams["nome"] = "login-form.php";

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     if ($email === 'test@example.com' && $password === 'password123') {
//         exit();
//     } else {
//         $templateParams["errorelogin"] = "Email o password errati!";
//     }
// }


require 'template/base-login.php';
?>