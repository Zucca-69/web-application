<?php
session_start();
require_once '../php_files/db_connection.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Verifica Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <a href="index.php"><h1>RunGame</h1></a>
</header>

<main>
    <section class="verify-form">
        <h2>Verifica il tuo account</h2>
        <form method="POST" action="../php_files/verifica_handler.php">
            <input type="hidden" name="utente" value="<?php echo htmlspecialchars($_GET['utente']); ?>">
            <label for="codice">Codice di verifica:</label>
            <input type="text" name="codice" id="codice" required>

            <button type="submit" class="btn">Verifica</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
