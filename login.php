<?php require_once __DIR__ . "/Templates/Header.php" ?>

<form action="./Backend/Login.php" method="post">
            <input type="email" placeholder="email" name="email">
            <input type="password" placeholder="Wachtwoord" name="password">

            <button type="submit">Login</button>
        </form>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>