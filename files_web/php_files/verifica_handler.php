<?php 
// Questo file gestisce la verifica dell'account tramite codice

session_start();
require_once 'db_connection.php'; // Connessione al database

if (isset($_POST['utente']) && isset($_POST['codice'])) {
    $utente = $_POST['utente'];
    $codice_inserito = $_POST['codice'];

    // Recupera codice di verifica dal database
    $sql = "SELECT codiceVerifica FROM Utenti WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $utente);
    $stmt->execute();
    $stmt->bind_result($codice_giusto);
    $stmt->fetch();
    $stmt->close();

    // Confronta codici
    if ($codice_inserito === $codice_giusto) {
        // Aggiorna stato a "verificato"
        $sql_update = "UPDATE Utenti SET verificato=1 WHERE username=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("s", $utente);
        $stmt_update->execute();
        $stmt_update->close();

        // Redirect a login con messaggio di successo
        echo "Verifica completata con successo!";
        header("Location: ../pagine/login.php?verificato=1");
        exit();
    } else {
        echo "Codice errato!";
    }

    $conn->close();
}
?>
