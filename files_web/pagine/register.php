<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Registrati</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <a href="index.php"><h1>RunGame</h1></a>
</header>

<main>
    <section class="register-form">
        <h2>Registrati</h2>
        <form action="../php_files/register_handler.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" required>

            <label for="dataNascita">Data di nascita:</label>
            <input type="date" id="dataNascita" name="dataNascita" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Registrati</button>
        </form>
        <p>Hai già un account? <a href="login.php">Accedi</a></p>
    </section>
</main>

<footer>
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
