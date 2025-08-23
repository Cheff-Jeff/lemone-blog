<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\SessionController;

SessionController::startSession();

$userActive = SessionController::isLoggedIn();

if (!$userActive) {
    header("Location: ./login.php");
}

$css = 'new-post';
$js = 'new-post';
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<section class="main-page new-post-page">
    <div class="container">
        <h1>Nieuwe post</h1>

        <form action="./Backend/NewPost.php" method="post">
            <input type="hidden" name="content" id="content">
            
            <input 
                type="text"
                name="title"
                placeholder="post titel"
                class="input-field title-field"
                required
            >
            <span class="inputError title small-text"></span>

            <div id="editor">
            </div>
            <span class="inputError content small-text"></span>
            
            <button type="submit" class="btn-primary">
                post plaatsten
            </button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>