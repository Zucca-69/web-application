<?php

// Questo file si occuperà di:

// Ricevere i dati

// Controllare l'utente sul database

// Avviare la sessione se corretto

// Rimandare alla homepage o mostrare errore

session_start();
require_once 'db_connection.php';

if (isset($_POST['nome_utente'])) {
    $username = $_POST['nome_utente'];
    $password = $_POST['la_sua_password'];

    $sql = "SELECT passwordHash, verificato FROM Utenti WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $verificato);
    $stmt->fetch();
    $stmt->close();

    if (!$hashed_password) {
        echo "Utente non riconosciuto";
    } elseif ($verificato == 0) {
        echo "Account non verificato. Controlla la tua email.";
    } elseif (password_verify($password, $hashed_password)) {
        $_SESSION['acceduto'] = TRUE;
        $_SESSION['username'] = $username;
        header("Location: ../pagine/index.php");
        exit();
    } else {
        echo "Password errata";
    }

    $conn->close();
}
?>

