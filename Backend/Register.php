<?php
declare(strict_types=1);
require_once("../vendor/autoload.php");

use PHP\Helpers\AuthController;


if (empty($_POST['email']) || empty($_POST['password'])) {
    return;
}

$authController = new AuthController();

try {
    $authController->register($_POST['email'], $_POST['password']);
}catch (\Exception $exception){
//    send back
}