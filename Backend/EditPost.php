<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\PostController;

if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['id']))
{
    header('Location: ../edit-post.php?error=1&postID='.$_GET['postID']);
}

try {
    $postController = new PostController();
    $newPost = $postController->updatePost(intval($_POST['id']), $_POST['title'], $_POST['content']);

    if ($newPost === false){
        throw new Exception();
    }

    header('Location: ../post.php?postID='.$_POST['id']);
} catch (\Throwable $th) {
    header('Location: ../edit-post.php?error=1&postID='.$_GET['postID']);
}