<?php
declare(strict_types=1);
require_once("../vendor/autoload.php");

use PHP\Helpers\AuthController;


if (empty($_POST['email']) || empty($_POST['password'])) {
    header('Location: ../login.php?error=1');
}

try {
    if (!is_string($_POST['email'])) throw new Exception("Email is geen string");
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) throw new Exception("E-mail is ongeldig");
    if (!is_string($_POST['password'])) throw new Exception("Password is geen string");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $authController = new AuthController();
    $result = $authController->login($email, $password);

    if ($result === false) {
        throw new Exception("Inloggen niet gelukt.");
    }

    header('Location: ../index.php');
}catch (\Exception $exception){
    header('Location: ../login.php?error=1');
}