<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\SessionController;

if (!isset($_GET['id']))
{
    header('Location: ../account.php?error=1');
}

try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");
    if (!is_numeric($_GET['id'])) throw new Exception("Id is geen number");

    $id = intval($_GET['id']);
    if (!SessionController::postBelongsToUser($id)) throw new Exception("De post is niet van u.");

    $postController = new PostController();
    $postDeleted = $postController->deletePost($id);

    if ($postDeleted === false){
        throw new Exception("Post is niet verwijderd");
    }

    header('Location: ../account.php');
}catch (\Throwable $th) {
    header('Location: ../account.php?error=1');
}