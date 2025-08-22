<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\ReactionController;
use PHP\Helpers\SessionController;

if (empty($_GET['postId']) || empty($_GET['id']))
{
    header('Location: ../post.php?postID='.$_GET['postId'].'error='. urlencode("Er is iets misgegaan."));
}

try {
    if (!SessionController::isLoggedIn()) throw new Exception("Gebruiker niet ingelogd");
    if (!is_numeric($_GET['postId'])) throw new Exception("Id is geen number");
    if (!is_numeric($_GET['id'])) throw new Exception("Id is geen number");

    $id = intval($_GET['id']);
    $postId = intval($_GET['postId']);
    if (!SessionController::reacrionBelongsToUser($id)) throw new Exception("De reactie is niet van u.");

    $reactionController = new ReactionController();
    $reactionDeleted = $reactionController->deleteReaction($id, $postId);

    if ($reactionDeleted === false){
        throw new Exception("Reactie is niet verwijderd");
    }

    header('Location: ../post.php?postID='.$_GET['postId'].'&success=' . urlencode("Reactie is verwijderd."));
} catch (\Exception $exception){
    header('Location: ../post.php?postID='.$_GET['postId'].'error='. urlencode($exception->getMessage()));
}