<?php $css = "login"; ?>
<?php require_once __DIR__ . "/Templates/Header.php" ?>
<section class="main-page">
    <div class="container">
        <h1 class="title">Login</h1>

        <form action="./Backend/Login.php" method="post">
            <input 
                type="email"
                placeholder="email"
                name="email"
                class="input-field"
                required
            >

            <input 
                type="password"
                placeholder="Wachtwoord"
                name="password"
                class="input-field"
                required
            >

            <button type="submit" class="btn-primary">Login</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . "/Templates/Footer.php" ?>