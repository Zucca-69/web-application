<?php 
// Avvia la sessione e include connessione al database
session_start();
require_once '../php_files/db_connection.php'; 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Verifica Account</title>
    <link rel="stylesheet" href="../css/autenticazione.css"> <!-- Collegamento al file CSS -->
</head>
<body>

<header>
    <!-- Logo collegato alla homepage -->
    <a href="index.php"><h1>RunGame</h1></a>
</header>

<main>
    <!-- Form per inserire codice di verifica -->
    <section class="verify-form">
        <h2>Verifica il tuo account</h2>
        <form method="POST" action="../php_files/verifica_handler.php">
            <!-- Campo nascosto per l'username passato via URL -->
            <input type="hidden" name="utente" value="<?php echo htmlspecialchars($_GET['utente']); ?>">

            <label for="codice">Codice di verifica:</label>
            <input type="text" name="codice" id="codice" required>

            <button type="submit" class="btn">Verifica</button>
        </form>
    </section>
</main>

<footer>
    <!-- Footer sito -->
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
