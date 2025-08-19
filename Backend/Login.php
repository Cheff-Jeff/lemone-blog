<?php
declare(strict_types=1);
require_once("../vendor/autoload.php");

use PHP\Helpers\AuthController;


if (empty($_POST['email']) || empty($_POST['password'])) {
    header('Location: ../login.php?error=1');
}

$authController = new AuthController();

try {
    $result = $authController->login($_POST['email'], $_POST['password']);
    if ($result === false) {
        throw new Exception();
    }

    header('Location: ../index.php');
}catch (\Exception $exception){
    header('Location: ../login.php?error=1');
}