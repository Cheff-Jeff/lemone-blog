<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\ReactionController;
use PHP\Helpers\SessionController;

if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['postId']))
{
    header('Location: ../post.php?postID='.$_POST['postId'].'error='.urlencode("Er is iets misgegaan."));
}

try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");
    if (!is_string($_POST['title'])) throw new Exception("Title is geen string");
    if (!is_string($_POST['content'])) throw new Exception("Content is geen string");
    if (!is_numeric($_POST['postId'])) throw new Exception("Id is geen number");

    $postId = intval($_POST['postId']);
    $title = strip_tags($_POST['title']);
    $content = $_POST['content'];

    $reactionController = new ReactionController();
    $reactionCreated = $reactionController->createReaction($postId, $title, $content);

    if ($reactionCreated === false){
        throw new Exception("Reactie aanmaken mislukt.");
    }

    header('Location: ../post.php?postID='.$_POST['postId'].'&success='.urlencode("Reactie is aangemaakt."));
}catch (\Exception $exception){
    header('Location: ../post.php?postID='.$_POST['postId'].'error='.urlencode($exception->getMessage()));
}