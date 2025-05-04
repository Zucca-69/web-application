<?php
session_start();
require_once("db_connection.php");

if (!isset($_SESSION['userId'])) {
    die("Utente non autenticato.");
}
$userId = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_img'])) {
    $file = $_FILES['profile_img'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Errore nel caricamento dell'immagine.");
    }

    // 1. Recupera l'immagine attuale dell'utente (se esiste)
    $stmtOld = $conn->prepare("SELECT FKimmagineProfilo FROM Utenti WHERE userId = ?");
    $stmtOld->bind_param("i", $userId);
    $stmtOld->execute();
    $stmtOld->bind_result($oldImageId);
    $stmtOld->fetch();
    $stmtOld->close();

    // 2. Parametri dell'immagine da salvare
    $imageData = file_get_contents($file['tmp_name']);
    $imageName = $file['name'];
    $imageType = $file['type'];
    $imageSize = $file['size'];
    $imageTmpName = $file['tmp_name'];
    $imageError = $file['error'];
    $imageURL = null;
    $uploadedOn = date("Y-m-d H:i:s");

    // 3. Inserisce la nuova immagine
    $stmtImg = $conn->prepare("INSERT INTO Immagini (imageData, imageName, imageType, imageSize, imageTmpName, imageError, imageURL, uploaded_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtImg->bind_param("bssissss", $null, $imageName, $imageType, $imageSize, $imageTmpName, $imageError, $imageURL, $uploadedOn);
    $stmtImg->send_long_data(0, $imageData);
    $stmtImg->execute();

    if ($stmtImg->affected_rows <= 0) {
        die("Errore nell'inserimento dell'immagine.");
    }

    $newImageId = $stmtImg->insert_id;
    $stmtImg->close();

    // 4. Aggiorna l'utente con la nuova immagine
    $stmtUser = $conn->prepare("UPDATE Utenti SET FKimmagineProfilo = ? WHERE userId = ?");
    $stmtUser->bind_param("ii", $newImageId, $userId);
    $stmtUser->execute();
    $stmtUser->close();

    // 5. Elimina la vecchia immagine se esiste
    if (!empty($oldImageId)) {
        $stmtDel = $conn->prepare("DELETE FROM Immagini WHERE imageId = ?");
        $stmtDel->bind_param("i", $oldImageId);
        $stmtDel->execute();
        $stmtDel->close();
    }

    $conn->close();
    header("Location: ../pagine/profilo.php"); // Redirect alla home
    exit();
} else {
    echo "Nessun file ricevuto.";
}
?>



<?php
// session_start();
// require_once("db_connection.php");

// if (!isset($_SESSION['userId'])) {
//     die("Utente non autenticato.");
// }
// $userId = $_SESSION['userId'];

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_img'])) {
//     $imageData = file_get_contents($_FILES['profile_img']['tmp_name']);
//     $mimeType = mime_content_type($_FILES['profile_img']['tmp_name']);

//     // 1. Inserisci immagine nella tabella Immagini
//     $imageSize = filesize($_FILES['profile_img']['tmp_name']);
//     $stmtImg = $conn->prepare("INSERT INTO Immagini (imageData, imageType, imageSize, uploaded_on) VALUES (?, ?, ?, NOW())");
//     $stmtImg->bind_param("bsi", $null, $mimeType, $imageSize);
//     $stmtImg->send_long_data(0, $imageData);
//     $stmtImg->execute();
//     $imageId = $stmtImg->insert_id;
//     $stmtImg->close();

//     // 2. Collega l'immagine all'utente
//     $stmtUser = $conn->prepare("UPDATE Utenti SET FKimmagineProfilo = ? WHERE userId = ?");
//     $stmtUser->bind_param("ii", $imageId, $userId);
//     $stmtUser->execute();
//     $stmtUser->close();

//     echo "Immagine aggiornata con successo.";
//     $conn->close();
//     header("Location: ../pagine/profilo.php"); // Redirect alla home
//     exit();
// } else {
//     echo "Nessun file ricevuto.";
// }
?>
