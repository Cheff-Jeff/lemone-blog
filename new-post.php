<?php
require_once __DIR__ . "/vendor/autoload.php";

\PHP\Helpers\SessionController::startSession();

$userActive = isset($_SESSION['token']);

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