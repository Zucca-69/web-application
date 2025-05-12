<?php
session_start();

// Se non sei loggato, ti rimando al login
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Impostazioni</title>
    <!-- collegamento dei file CSS globali + specifici -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/autenticazione.css">
</head>
<body>

<?php include '../php_files/header_check.php'; ?>

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

        <!-- Cambio Tema -->
        <section>
            <h3>Cambia Tema</h3>
            <button id="toggle-theme" class="btn">Attiva/disattiva Tema Scuro</button>
            <p style="margin-top: 10px;">Il tema verrà salvato nel browser.</p>
        </section>


    </section>
</main>

<footer>
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
