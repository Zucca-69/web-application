<?php
session_start();
require_once 'db_connection.php';

// Se non sei loggato, ti rimando al login
if (!isset($_SESSION['username'])) {
    header("Location: ../pagine/login.php");
    exit();
}

// Controllo se l'email è stata inviata
if (isset($_POST['new_email']) && !empty($_POST['new_email'])) {
    $new_email = trim($_POST['new_email']);
    $username = $_SESSION['username'];

    // Aggiorno l'email nel database
    $sql = "UPDATE Utenti SET email = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_email, $username);

    if ($stmt->execute()) {
        echo "Email aggiornata con successo!";
        // Redirect opzionale
        header("Location: ../pagine/impostazioni.php?success=email");
        exit();
    } else {
        echo "Errore durante l'aggiornamento dell'email: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
