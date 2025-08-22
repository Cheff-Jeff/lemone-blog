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
$js = 'post';

foreach ($reactions as $reaction) {
    if ($currentUser && $reaction->user->id === $currentUser->id) {
        $userHasResponed = true;
        break;
    }
}
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
    <section class="main-page">
        <div class="container">
            <article class="full-post">
                <div class="author">
                    Geplaats op <?= date('d-m-y', strtotime($post->created_at)) ?> 
                    door <?=SanitizeHTML::outputCleanHTML($user->email)?>
                </div>

                <div class="content">
                    <h1 class="title">
                        <?=SanitizeHTML::outputCleanHTML($post->title)?>
                    </h1>

                    <div class="content">
                        <?= html_entity_decode(
                            $post->content,
                            ENT_QUOTES | ENT_HTML5,
                            'UTF-8'); 
                        ?>
                    </div>
                </div>
            </article>

            <div class="reactions-title">
                <h2>Reacties: </h2>

                <?php if ($currentUser && !$userHasResponed): ?>
                    <button id="modal-trigger" class="btn-primary">
                        Plaats reactie
                    </button>
                <?php endif; ?>
            </div>
            <?php if ($reactions): ?>
                <div class="reactions">
                    <?php foreach ($reactions as $reaction): ?>
                        <div class="reaction">
                            <h5 class="title">
                                <?= SanitizeHTML::outputCleanHTML($reaction->title) ?>
                            </h5>
                            
                            <p>
                                <?= SanitizeHTML::outputCleanHTML($reaction->content) ?>
                            </p>
                            
                            <span class="small-text">
                                Geplaats op <?= date('d-m-y', strtotime($reaction->created_at)) ?> 
                                door<?= SanitizeHTML::outputCleanHTML($reaction->user->email) ?>
                            </span>

                            <?php if ($currentUser && $reaction->user->id === $currentUser->id): ?>
                                <div class="btn-wrap">
                                    <a id="edit-trigger" href="#" class="btn-edit">
                                        Bewerken
                                    </a>

                                    <a href="./Backend/DeleteReaction.php?postId=<?=$post->id?>&id=<?=$reaction->id?>" class="btn-delete">
                                        Verwijderen
                                    </a>
                                </div>

                                <form action="./Backend/EditReaction.php" method="post" class="edit-reaction-form hide">
                                    <input type="hidden" name="postId" value="<?=$post->id?>">
                                    <input type="hidden" name="id" value="<?=$reaction->id?>">
                                    
                                    <input
                                        type="text"
                                        name="title"
                                        placeholder="Reactie titel"
                                        value="<?= SanitizeHTML::outputCleanHTML($reaction->title) ?>"
                                        class="input-field"
                                        required
                                    >
                                    
                                    <input 
                                        type="text"
                                        name="content"
                                        placeholder="Reactie content"
                                        value="<?= SanitizeHTML::outputCleanHTML($reaction->content) ?>"
                                        class="input-field"
                                        required
                                    >
                                    
                                    <button type="submit" class="btn-primary">
                                        Bewerken
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($currentUser && !$userHasResponed): ?>
        <div class="modal hide">
            <div class="modal-content">
                <form action="./Backend/NewReaction.php" method="post">
                    <span class="close">sluiten</span>
                    <h3 class="title">Reactie plaatsen</h3>

                    <input type="hidden" name="postId" value="<?=$post->id?>">

                    <input 
                        type="text" 
                        name="title" 
                        placeholder="Reactie titel"
                        class="input-field"
                        required
                    >
                    
                    <input 
                        type="text" 
                        name="content" 
                        placeholder="Reactie content"
                        class="input-field"
                        required    
                    >
                    
                    <button type="submit" class="btn-primary">Plaatsen</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>