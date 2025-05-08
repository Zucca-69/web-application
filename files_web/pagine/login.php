<?php 
// Avvia la sessione per gestire login dell'utente
session_start(); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Login</title>
    <!-- collegamento dei file CSS globali + specifici -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/autenticazione.css">
</head>
<body>

<header>
    <!-- Logo che riporta alla homepage -->
    <div class="logo">
            <a href="index.php">
                <img src="../MEDIA/immagini/Logo.png" alt="Logo">
            </a>
</header>

<main>
    <!-- Form di login -->
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

    <!-- Messaggio di successo dopo verifica account -->
    <?php if (isset($_GET['verificato'])): ?>
        <p class="success">Account verificato! Ora puoi accedere.</p>
    <?php endif; ?>
</main>

<footer>
    <!-- Footer con copyright -->
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
