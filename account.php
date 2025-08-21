<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\UserController;
use PHP\Helpers\SessionController;
use PHP\Helpers\SanitizeHTML;
use PHP\Modals\Post;

SessionController::startSession();
$userActive = SessionController::isLoggedIn();

if (!$userActive) {
    header("Location: ./login.php");
}
$userController = new UserController();
$user = $userController->getUserByToken();

/** @var Post[] $userPosts */
$userPosts = $userController->getUserPosts();
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
<div class="container">
    <h1>Hallo <?=SanitizeHTML::outputCleanHTML($user->email)?></h1>

    <?php foreach ($userPosts as $post) : ?>
        <div class="post">
            <h5><?= $post->title ?></h5>

            <div class="buttons">
                <a href="./edit-post.php?postID=<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">bewerken</a>

                <a href="./Backend/DeletePost.php?id=<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">verwijderen</a>
            </div>
        </div>

    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>
