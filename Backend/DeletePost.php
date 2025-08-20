<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\PostController;

if (!isset($_GET['id']))
{
    header('Location: ../account.php?error=1');
}

try {
    $postController = new PostController();
    $postDeleted = $postController->deletePost(intval($_GET['id']));

    if ($postDeleted === false){
        throw new Exception();
    }

    header('Location: ../account.php');
}catch (\Throwable $th) {
    header('Location: ../account.php?error=1');
}