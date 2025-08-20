<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\SanitizeHTML;
use PHP\Modals\Post;
use PHP\Modals\User;

if (!isset($_GET['postID'])) {
    header('Location: /index.php');
}
$postController = new PostController();

$postData = $postController->getPost($_GET['postID']);

if (!$postData) {
    header('Location: /index.php');
}

/** @var User $user */
/** @var Post $post */
$user = $postData['user'];
$post = $postData['post'];
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
    <article>
        <h1><?=SanitizeHTML::outputCleanHTML($post->title)?></h1>

        <p><?=SanitizeHTML::outputCleanHTML($post->content)?></p>

        <footer>
            posted on <?= date('d-m-y', strtotime($post->created_at)) ?> by <?=SanitizeHTML::outputCleanHTML($user->email)?>
        </footer>
    </article>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>