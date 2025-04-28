<?php 
// Questo file gestisce il login dell'utente

session_start();
require_once 'db_connection.php'; // Connessione al database

if (isset($_POST['nome_utente'])) {
    // Ricezione dati dal form
    $username = $_POST['nome_utente'];
    $password = $_POST['la_sua_password'];

    // Recupera password hash e stato verifica dal DB
    $sql = "SELECT passwordHash, verificato FROM Utenti WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $verificato);
    $stmt->fetch();
    $stmt->close();

    // Controllo credenziali
    if (!$hashed_password) {
        echo "Utente non riconosciuto";
    } elseif ($verificato == 0) {
        echo "Account non verificato. Controlla la tua email.";
    } elseif (password_verify($password, $hashed_password)) {
        // Login riuscito: imposta sessione
        $_SESSION['acceduto'] = TRUE;
        $_SESSION['username'] = $username;
        header("Location: ../pagine/index.php"); // Redirect alla home
        exit();
    } else {
        echo "Password errata";
    }

    $conn->close();
}
?>
