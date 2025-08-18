<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\AuthController;

$authController = new AuthController();

try {
    $result = $authController->logout();

    if($result === false){
        throw new Exception();
    }

    header('Location: ../index.php');
}catch (\Exception $exception){
    header('Location: ../index.php?error=1');
}