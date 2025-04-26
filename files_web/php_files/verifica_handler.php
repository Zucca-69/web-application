<?php
session_start();
require_once 'db_connection.php';

if (isset($_POST['utente']) && isset($_POST['codice'])) {
    $utente = $_POST['utente'];
    $codice_inserito = $_POST['codice'];

    $sql = "SELECT codiceVerifica FROM Utenti WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $utente);
    $stmt->execute();
    $stmt->bind_result($codice_giusto);
    $stmt->fetch();
    $stmt->close();

    if ($codice_inserito === $codice_giusto) {
        $sql_update = "UPDATE Utenti SET verificato=1 WHERE username=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("s", $utente);
        $stmt_update->execute();
        $stmt_update->close();

        echo "Verifica completata con successo!";
        header("Location: ../pagine/login.php?verificato=1");
        exit();
    } else {
        echo "Codice errato!";
    }

    $conn->close();
}
?>
