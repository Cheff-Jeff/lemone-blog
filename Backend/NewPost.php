<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

use PHP\Helpers\PostController;

if (empty($_POST['title']) || empty($_POST['content']))
{
    header('Location: ../new-post.php?error=1');
}

try {
    $postController = new PostController();
    $newPost = $postController->createPost($_POST['title'], $_POST['content']);

    var_dump($newPost);

    if ($newPost === false){
        var_dump("Dit is false");
        throw new Exception();
    }

    header('Location: ../post.php?postID='.$newPost->id);
} catch (\Throwable $th) {
    header('Location: ../new-post.php?error=1');
}