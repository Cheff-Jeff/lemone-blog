<?php
require_once __DIR__ . "/vendor/autoload.php";

use PHP\Helpers\SessionController;

SessionController::startSession();

$userActive = SessionController::isLoggedIn();

if (!$userActive) {
    header("Location: ./login.php");
}
?>

<?php require_once __DIR__ . "/Templates/Header.php" ?>
    <form action="./Backend/NewPost.php" method="post">
        <input type="text" name="title" placeholder="post titel">
        <textarea name="content" placeholder="post content"></textarea>

        <button type="submit">post plaatsten</button>
    </form>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>