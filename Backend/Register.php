<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\AuthController;


if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "Hier Niet komen";
    return;
}
echo "Hierwel";
$authController = new AuthController();

try {
    $result = $authController->register($_POST['email'], $_POST['password']);

    if ($result === false) {
        throw new Exception();
    }

    header('Location: ../index.php');
}catch (\Exception $exception){
    header('Location: ../register.php?error=1');
}