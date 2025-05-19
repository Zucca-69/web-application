<?php
session_start();
if (!isset($_SESSION['checkout_success'])) {
    header("Location: carrello.php");
    exit();
}
unset($_SESSION['checkout_success']);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Checkout Completato</title>
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
    <?php include '../php_files/header.php'; ?>
    
    <div class="container">
        <h1>Ordine Completato con Successo!</h1>
        <p>Grazie per il tuo acquisto. Riceverai una email di conferma a breve.</p>
        <a href="../pagine/catalogo.php" class="btn">Torna al Catalogo</a>
    </div>
    
    <?php include '../php_files/footer.php'; ?>
</body>
</html>