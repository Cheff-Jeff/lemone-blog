<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\PostController;
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
    <artice>
        <h1><?= $post->title ?></h1>

        <p><?= $post->content ?></p>

        <footer>
            posted on <?= $post->created_at ?> by <?= $user->email ?>
        </footer>
    </artice>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>