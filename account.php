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
$css = 'account';
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
<section class="main-page">
    <div class="container">
        <h1 class="account-page-title">
            Hallo <?=SanitizeHTML::outputCleanHTML($user->email)?>
        </h1>

        <h3 class="subtitle">Jouw posts: </h3>
        
        <div class="post-cards">
            <?php foreach ($userPosts as $post) : ?>
                <div class="post">
                    <h5><?= $post->title ?></h5>

                    <div class="buttons">
                        <a class="edit" href="./edit-post.php?postID=<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">bewerken</a>

                        <a class="delete" href="./Backend/DeletePost.php?id=<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">verwijderen</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>
