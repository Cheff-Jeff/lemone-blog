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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/styles/variables.css">
    <link rel="stylesheet" href="../src/styles/header.css">
    <link rel="stylesheet" href="../src/styles/main.css">
    <?php if (isset($css)) : ?>
        <link rel="stylesheet" href="../src/styles/<?=$css?>.css">
    <?php endif; ?>    
    <title>Lemone - Blog</title>
</head>
<body>
<main>
    <header class="main-header">
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
                        <a href="../new-post.php">nieuwe post</a>
                    </li>
                    <li>
                        <a href="../account.php">account</a>
                    </li>
                    <li>
                        <a href="../Backend/Logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <?php if(isset($_GET['error'])): ?>
        <div class="error-note"> <?= urldecode($_GET['error']) ?> </div>
    <?php endif; ?>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="good-note"> <?= urldecode($_GET['success']) ?> </div>
    <?php endif; ?>
