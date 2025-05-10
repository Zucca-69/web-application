<?php
session_start();
require_once 'db_connection.php';

// Se non sei loggato, ti rimando al login
if (!isset($_SESSION['userId'])) {
    header("Location: ../pagine/login.php");
    exit();
}

// Controllo se sono state inviate entrambe le password
if (isset($_POST['current_password']) && isset($_POST['new_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $username = $_SESSION['username'];

    // Recupero l'hash della password attuale dal database
    $sql = "SELECT passwordHash FROM Utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($passwordHash);
    $stmt->fetch();
    $stmt->close();

    // Verifico che la password attuale sia corretta
    if (password_verify($current_password, $passwordHash)) {
        // Aggiorno la password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $sql_update = "UPDATE Utenti SET passwordHash = ? WHERE username = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $new_password_hash, $username);

        if ($stmt_update->execute()) {
            echo "Password aggiornata con successo!";
            // Redirect opzionale
            header("Location: ../pagine/impostazioni.php?success=password");
            exit();
        } else {
            echo "Errore durante l'aggiornamento della password: " . $stmt_update->error;
        }

        $stmt_update->close();
    } else {
        echo "Password attuale errata.";
    }
}

$conn->close();
?>
