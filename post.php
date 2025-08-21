<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\ReactionController;
use PHP\Helpers\SanitizeHTML;
use PHP\Helpers\UserController;
use PHP\Modals\Post;
use PHP\Modals\Reaction;
use PHP\Modals\User;

if (!isset($_GET['postID'])) {
    header('Location: /index.php');
}
$postController = new PostController();
$reactionController = new ReactionController();

$postData = $postController->getPost($_GET['postID']);

if (!$postData) {
    header('Location: /index.php');
}

/** @var User $user */
/** @var Post $post */
/** @var Reaction[] $reactions */
$user = $postData['user'];
$post = $postData['post'];
$reactions = $reactionController->getPostReactions($post->id);

$userController = new UserController();
$currentUser = $userController->getUserByToken();
$userHasResponed = false;
$css = 'post';
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
    <section class="main-page">
        <div class="container">
            <article class="full-post">
                <div class="author">
                    Geplaats op <?= date('d-m-y', strtotime($post->created_at)) ?> door <?=SanitizeHTML::outputCleanHTML($user->email)?>
                </div>

                <div class="content">
                    <h1 class="title"><?=SanitizeHTML::outputCleanHTML($post->title)?></h1>
                    <p><?=SanitizeHTML::outputCleanHTML($post->content)?></p>
                </div>
            </article>

            <?php if ($reactions): ?>
                <h2>Reacties: </h2>
                
                <div class="reactions">
                    <?php foreach ($reactions as $reaction): ?>
                        <?php if ($currentUser && $reaction->user->id === $currentUser->id) {$userHasResponed = true;} ?>
                        <div class="reaction">
                            <h5 class="title"><?= SanitizeHTML::outputCleanHTML($reaction->title) ?></h5>
                            <p><?= SanitizeHTML::outputCleanHTML($reaction->content) ?></p>
                            <span class="small-text">
                                Geplaats op <?= date('d-m-y', strtotime($reaction->created_at)) ?> door
                                <?= SanitizeHTML::outputCleanHTML($reaction->user->email) ?>
                            </span>

                            <?php if ($currentUser && $reaction->user->id === $currentUser->id): ?>
            <!--                    <a href="#">Bewerken</a>-->
                                <a href="./Backend/DeleteReaction.php?postId=<?=$post->id?>&id=<?=$reaction->id?>">Verwijderen</a>

                                <form action="./Backend/EditReaction.php" method="post">
                                    <input type="text" name="title" placeholder="Reactie titel" value="<?= SanitizeHTML::outputCleanHTML($reaction->title) ?>">
                                    <input type="text" name="content" placeholder="Reactie content" value="<?= SanitizeHTML::outputCleanHTML($reaction->content) ?>">
                                    <input type="hidden" name="postId" value="<?=$post->id?>">
                                    <input type="hidden" name="id" value="<?=$reaction->id?>">
                                    <button type="submit">Bewerken</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($currentUser && !$userHasResponed): ?>
                <form action="./Backend/NewReaction.php" method="post">
                    <input type="text" name="title" placeholder="Reactie titel">
                    <input type="text" name="content" placeholder="Reactie content">
                    <input type="hidden" name="postId" value="<?=$post->id?>">
                    <button type="submit">Plaatsen</button>
                </form>
            <?php endif; ?>
        </div>
    </section>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>