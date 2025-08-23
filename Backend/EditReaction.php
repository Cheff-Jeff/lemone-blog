<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\ReactionController;
use PHP\Helpers\SessionController;

if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['postId']) || empty($_POST['id']))
{
    header('Location: ../post.php?postID='.$_POST['postId'].'error='.urlencode("Er is iets misgegaan."));
}

try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");
    if (!is_string($_POST['title'])) throw new Exception("Title is geen string");
    if (!is_string($_POST['content'])) throw new Exception("Content is geen string");
    if (!is_numeric($_POST['postId'])) throw new Exception("Id is geen number");
    if (!is_numeric($_POST['id'])) throw new Exception("Id is geen number");

    $id = intval($_POST['id']);
    if (!SessionController::reacrionBelongsToUser($id)) throw new Exception("De reactie is niet van u.");

    $postId = intval($_POST['postId']);
    $title = strip_tags($_POST['title']);
    $content = $_POST['content'];

    $reactionController = new ReactionController();
    $reactionUpdated = $reactionController->updateReaction($id, $postId, $title, $content);

    if ($reactionUpdated === false){
        header('Location: ../post.php?postID='.$_POST['postId'].'error=1');
    }

    header('Location: ../post.php?postID='.$_POST['postId'].'&success='.urlencode("Reactie is geupdate."));
} catch (\Exception $exception){
    header('Location: ../post.php?postID='.$_POST['postId'].'error='.urlencode($exception->getMessage()));
}