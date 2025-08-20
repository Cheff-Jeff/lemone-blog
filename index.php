<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\SanitizeHTML;
use PHP\Modals\Post;
use PHP\Modals\User;

$postController = new PostController();
$posts = $postController->getAllPosts();
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>

    <div class="cointainer">
        <h1>Lemone - Blog</h1>

        <?php if($posts) : ?>
            <div class="posts">
                <?php foreach ($posts as $post) : ?>
                    <?php /** @var Post $blogPost */ $blogPost = $post['post'];?>
                    <?php /** @var User $author */ $author = $post['user']; ?>

                    <a href="./post.php?postID=<?=$blogPost->id?>">
                        <article>
                            <h4><?=SanitizeHTML::outputCleanHTML($blogPost->title)?></h4>
                            <p><?=SanitizeHTML::outputCleanHTML($blogPost->content)?></p>

                            <footer>
                                created at <?= date('d-m-y', strtotime($blogPost->created_at)) ?> by <?=SanitizeHTML::outputCleanHTML($author->email)?>
                            </footer>
                        </article>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>