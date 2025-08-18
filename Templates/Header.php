<?php
require_once __DIR__ . "/../vendor/autoload.php";

\PHP\Helpers\SessionController::startSession();

$userActive = isset($_SESSION['token']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registreren</title>
</head>
<body>
<main>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="../index.php">Home</a>
                </li>
                <?PHP if (!$userActive) :?>
                <li>
                    <a href="../login.php">Login</a>
                </li>
                <li>
                    <a href="../register.php">Register</a>
                </li>
                <?php else : ?>
                <li>
                    <a href="../Backend/Logout.php">Logout</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <?php if(isset($_GET['error'])): ?>
        <div> probleem </div>
    <?php endif; ?>
