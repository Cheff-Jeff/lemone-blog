<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\AuthController;
use PHP\Helpers\SessionController;


try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");

    $authController = new AuthController();
    $result = $authController->logout();

    if($result === false){
        throw new Exception("uitloggen mislukt.");
    }

    header('Location: ../index.php');
}catch (\Exception $exception){
    header('Location: ../index.php?error=1');
}