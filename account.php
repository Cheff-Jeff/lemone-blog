<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\UserController;
use PHP\Modals\Post;

\PHP\Helpers\SessionController::startSession();

$userActive = isset($_SESSION['token']);

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
    <h1>Hello <?=$user->email?></h1>

    <?php foreach ($userPosts as $post) : ?>
        <div class="post">
            <h5><?= $post->title ?></h5>

            <div class="buttons">
                <a href="./edit-post.php?postID=<?=$post->id?>">bewerken</a>

                <a href="#">verwijderen</a>
            </div>
        </div>

    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>
