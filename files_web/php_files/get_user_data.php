<?php
session_start();
require_once 'db_connection.php'; // Assicurati che punti correttamente al file

// Verifica che l'utente sia loggato
if (!isset($_SESSION['userId'])) {
    header("Location: ../pagine/login.php");
    exit();
}

$userId = $_SESSION['userId']; // La chiave che usi per tracciare l’utente nella sessione

// Query per ottenere i dati dell'utente
$sql = "SELECT nome, cognome, username, email, dataNascita, '' AS bio FROM utenti WHERE userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
