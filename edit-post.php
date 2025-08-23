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

$css = 'new-post';
$js = 'edit-post';
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<section class="main-page new-post-page">
    <div class="container">
        <h1>Post bewerken</h1>

        <form action="./Backend/EditPost.php" method="post">
            <input type="hidden" name="content" id="content" value='<?=$post->content?>'>
            <input type="hidden" name="id" value="<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">
            
            <input 
                type="text"
                name="title"
                placeholder="post titel"
                class="input-field title-field"
                value="<?=SanitizeHTML::outputCleanHTML($post->title)?>"
                required
            >
            <span class="inputError title small-text"></span>

            <div id="editor">
            </div>
            <span class="inputError content small-text"></span>
            
            <button type="submit" class="btn-primary">
                post opslaan
            </button>
        </form>
    </div>
</section>

    <!-- <form action="./Backend/EditPost.php" method="post">
        <input type="hidden" name="id" value="<?=SanitizeHTML::outputCleanHTML(strval($post->id))?>">
        <input type="text" name="title" value="<?=SanitizeHTML::outputCleanHTML($post->title)?>" placeholder="post titel">
        <textarea name="content" placeholder="post content"><?=SanitizeHTML::outputCleanHTML($post->content)?></textarea>

        <button type="submit">post opslaan</button>
    </form> -->
<?php require_once __DIR__ . "/Templates/Footer.php" ?>