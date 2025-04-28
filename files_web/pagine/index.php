<?php 
// Avvia la sessione per gestire login/logout
session_start(); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>RunGame - Home</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Collegamento al file CSS -->
</head>
<body>

<header>
    <!-- Logo e navigazione principale -->
    <a href="index.php"><h1>RunGame</h1></a>
    <nav>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Giochi</a></li>
            <li><a href="#">Classifica</a></li>
        </ul>
        <ul class="nav-user">
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Se l'utente è loggato, mostra link al profilo e carrello -->
                <li><a href="profile.php">Profilo</a></li>
                <li><a href="cart.php">Carrello</a></li>
            <?php else: ?>
                <!-- Se l'utente NON è loggato, mostra link a login e registrazione -->
                <li><a href="login.php">Accedi</a></li>
                <li><a href="register.php">Registrati</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <!-- Sezione principale di benvenuto -->
    <section class="hero">
        <h2>Inizia la tua avventura!</h2>
        <p>Scopri nuovi giochi in sconto da noi su RunGame.</p>
        <a href="#" class="btn">Scopri di più</a>
    </section>
</main>

<footer>
    <!-- Footer con copyright -->
    <p>&copy; 2025 RunGame. Tutti i diritti riservati.</p>
</footer>

</body>
</html>
