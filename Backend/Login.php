<?php
declare(strict_types=1);
require_once("../vendor/autoload.php");

use PHP\Helpers\AuthController;


if (empty($_POST['email']) || empty($_POST['password'])) {
    header('Location: ../login.php?error='.urlencode("Vul alle velden in."));
}

try {
    if (!is_string($_POST['email'])) throw new Exception("Dit is geen geldige e-mail");
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) throw new Exception("Dit is geen geldige e-mail");
    if (!is_string($_POST['password'])) throw new Exception("Dit is geen geldige wachtwoord");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $authController = new AuthController();
    $result = $authController->login($email, $password);

    if ($result === false) {
        throw new Exception("Inloggen niet gelukt.");
    }

    header('Location: ../index.php?success='.urlencode("Welkom!"));
}catch (\Exception $exception){
    header('Location: ../login.php?error='.urlencode($exception->getMessage()));
}