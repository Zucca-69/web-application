<!-- 
session_start();
require_once("db_connection.php");

if (!isset($_SESSION['userId'])) {
    die("Errore: utente non autenticato.");
}
$userId = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_img'])) {
    $imageData = file_get_contents($_FILES['profile_img']['tmp_name']);

    $stmt = $conn->prepare("UPDATE Utenti SET imgProfilo = ? WHERE userId = ?");
    $stmt->bind_param("bi", $null, $userId);

    // binding del blob manuale
    $stmt->send_long_data(0, $imageData);

    if ($stmt->execute()) {
        echo "Immagine del profilo aggiornata nel database!";
    } else {
        echo "Errore nel salvataggio: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../pagine/profilo.php"); // Redirect alla home
    exit();
} else {
    echo "Nessuna immagine ricevuta.";
}

 -->

<?php
session_start();
require_once("db_connection.php");

if (!isset($_SESSION['userId'])) {
    die("Utente non autenticato.");
}
$userId = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_img'])) {
    $imageData = file_get_contents($_FILES['profile_img']['tmp_name']);
    $mimeType = mime_content_type($_FILES['profile_img']['tmp_name']);

    // 1. Inserisci immagine nella tabella Immagini
    $imageSize = filesize($_FILES['profile_img']['tmp_name']);
    $stmtImg = $conn->prepare("INSERT INTO Immagini (imageData, imageType, imageSize) VALUES (?, ?, ?)");
    $stmtImg->bind_param("bsi", $null, $mimeType, $imageSize);
    $stmtImg->send_long_data(0, $imageData);
    $stmtImg->execute();
    $imageId = $stmtImg->insert_id;
    $stmtImg->close();

    // 2. Collega l'immagine all'utente
    $stmtUser = $conn->prepare("UPDATE Utenti SET FKimmagineProfilo = ? WHERE userId = ?");
    $stmtUser->bind_param("ii", $imageId, $userId);
    $stmtUser->execute();
    $stmtUser->close();

    echo "Immagine aggiornata con successo.";
    $conn->close();
    header("Location: ../pagine/profilo.php"); // Redirect alla home
    exit();
} else {
    echo "Nessun file ricevuto.";
}
?>
