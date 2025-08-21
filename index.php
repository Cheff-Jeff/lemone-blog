<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\PostController;
use PHP\Helpers\SanitizeHTML;
use PHP\Modals\Post;
use PHP\Modals\User;

$postController = new PostController();
$posts = $postController->getAllPosts();
$css = 'home';
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
    <section class="main-page">
        <div class="container">
            <h1 class="heading-big ">Lemone - Blog</h1>

            <?php if($posts) : ?>
                <div class="posts">
                    <?php foreach ($posts as $post) : ?>
                        <?php /** @var Post $blogPost */ $blogPost = $post['post'];?>
                        <?php /** @var User $author */ $author = $post['user']; ?>

                        <a href="./post.php?postID=<?=$blogPost->id?>" class="post-card">
                            <article>
                                <h4 class="title"><?=SanitizeHTML::outputCleanHTML($blogPost->title)?></h4>
                                <p><?=SanitizeHTML::outputCleanHTML($blogPost->content)?></p>

                                <footer>
                                    <span class="small-text">
                                        Geplaats op <?= date('d-m-y', strtotime($blogPost->created_at)) ?> door <?=SanitizeHTML::outputCleanHTML($author->email)?>
                                    </span>
                                </footer>
                            </article>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>