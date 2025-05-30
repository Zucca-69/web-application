<?php 
// Questo file gestisce il login dell'utente

session_start();
require_once 'db_connection.php'; // Connessione al database

if (isset($_POST['nome_utente'])) {
    // Ricezione dati dal form
    $username = $_POST['nome_utente'];
    $password = $_POST['la_sua_password'];

    // Recupera userId, password hash e stato verifica dal DB
    $sql = "SELECT userId, passwordHash, verificato FROM Utenti WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashed_password, $verificato);
    $stmt->fetch();
    $stmt->close();

    // Controllo credenziali
    if (!$hashed_password) {
        header("Location: ../pagine/login.php?error=utente");
        exit();
    } elseif ($verificato == 0) {
        header("Location: ../pagine/login.php?error=verifica");
        exit();
    } elseif (password_verify($password, $hashed_password)) {
        // Login riuscito: imposta sessione (salviamo questi dati)
        $_SESSION['acceduto'] = TRUE;
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $userId;  
        header("Location: ../pagine/index.php"); // Redirect alla home
        exit();
    } else {
        header("Location: ../pagine/login.php?error=password");
    }

    $conn->close();
}
?>