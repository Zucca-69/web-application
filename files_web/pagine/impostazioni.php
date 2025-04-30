<?php
session_start();

// Se non sei loggato, ti rimando al login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Impostazioni</title>
    <link rel="stylesheet" href="../css/STILE.css">
</head>
<body>

<header>
    <a href="index.php"><h1>RunGame</h1></a>
</header>

<main>
    <section class="settings-form">
        <h2>Impostazioni Account</h2>

        <!-- Cambio Email -->
        <form action="../php_files/update_email.php" method="POST">
            <h3>Cambia Email</h3>
            <label for="new_email">Nuova Email:</label>
            <input type="email" id="new_email" name="new_email" required>
            <button type="submit" class="btn">Aggiorna Email</button>
        </form>

        <!-- Cambio Password -->
        <form action="../php_files/update_password.php" method="POST">
            <h3>Cambia Password</h3>
            <label for="current_password">Password Attuale:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">Nuova Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit" class="btn">Aggiorna Password</button>
        </form>

        <!-- Cambio Tema (Placeholder) -->
        <section>
            <h3>Cambia Tema (prossimamente)</h3>
            <p>Presto potrai scegliere tra tema chiaro, scuro e altri colori!</p>
        </section>

    </section>
</main>

<footer>
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
