<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\UserController;
use PHP\Helpers\SessionController;
use PHP\Helpers\SanitizeHTML;
use PHP\Modals\Post;

SessionController::startSession();

if (!SessionController::isLoggedIn()) {
    header("Location: ./login.php");
}
if (!isset($_GET['postID'])) {
    header('Location: /index.php');
}

$postController = new PostController();
$userController = new UserController();
$postData = $postController->getPost($_GET['postID']);

/** @var Post $post */
$post = $postData['post'];
$user = $userController->getUserByToken();

if (!$post || !$user || !SessionController::postBelongsToUser($post->id)) {
    header('Location: /index.php');
}
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
    <form action="./Backend/EditPost.php" method="post">
        <input type="hidden" name="id" value="<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">
        <input type="text" name="title" value="<?=SanitizeHTML::outputCleanHTML($post->title)?>" placeholder="post titel">
        <textarea name="content" placeholder="post content"><?=SanitizeHTML::outputCleanHTML($post->content)?></textarea>

        <button type="submit">post opslaan</button>
    </form>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>