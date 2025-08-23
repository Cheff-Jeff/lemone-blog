<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\SessionController;

if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['id']))
{
    header('Location: ../edit-post.php?error=1&postID='.$_POST['id']);
}

try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");
    if (!is_numeric($_POST['id'])) throw new Exception("Id is geen number");
    if (!is_string($_POST['title'])) throw new Exception("Title is geen string");
    if (!is_string($_POST['content'])) throw new Exception("Content is geen string");

    $id = intval($_POST['id']);
    if (!SessionController::postBelongsToUser($id)) throw new Exception("De post is niet van u.");

    $title = strip_tags($_POST['title']);
    $content = $_POST['content'];

    $postController = new PostController();
    $newPost = $postController->updatePost($id, $title, $content);

    if ($newPost === false){
        throw new Exception("de post is niet geupdate");
    }

    header('Location: ../post.php?postID='.$id);
} catch (\Throwable $th) {
    header('Location: ../edit-post.php?error=1&postID='.$_POST['id']);
}