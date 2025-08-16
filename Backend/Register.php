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
    $authController->register($_POST['email'], $_POST['password']);
}catch (\Exception $exception){
//    send back
}