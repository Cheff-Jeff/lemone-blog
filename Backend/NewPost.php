<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\SessionController;

if (empty($_POST['title']) || empty($_POST['content']))
{
    header('Location: ../new-post.php?error='.urlencode("Er is iets misgegaan."));
}

try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");
    if (!is_string($_POST['title'])) throw new Exception("Title is geen text");
    if (!is_string($_POST['content'])) throw new Exception("Content is geen text");

    $title = strip_tags($_POST['title']);
    $content = $_POST['content'];

    $postController = new PostController();
    $newPost = $postController->createPost($title, $content);

    if ($newPost === false){
        throw new Exception("Post aanmaken mislukt.");
    }

    header('Location: ../post.php?postID='.$newPost->id.'&success='.urlencode("Post is aangemaakt."));
} catch (\Exception $exception) {
    header('Location: ../new-post.php?error='.urlencode($exception->getMessage()));
}