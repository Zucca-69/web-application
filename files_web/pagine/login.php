<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <a href="index.php"><h1>RunGame</h1></a>
</header>

<main>
    <section class="login-form">
        <h2>Accedi</h2>
        <form action="../php_files/login_handler.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="nome_utente" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="la_sua_password" required>

            <button type="submit" class="btn">Accedi</button>
        </form>
        <p>Non hai un account? <a href="register.php">Registrati</a></p>
    </section>

    <?php if (isset($_GET['verificato'])): ?>
        <p class="success">Account verificato! Ora puoi accedere.</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>

