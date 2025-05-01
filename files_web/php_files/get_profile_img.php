<?php
session_start();
require_once("db_connection.php");

if (!isset($_SESSION['userId'])) {
    http_response_code(403);
    exit("Non autorizzato");
}

$userId = $_SESSION['userId'];

// Recupera FKimmagineProfilo dell’utente
$stmt1 = $conn->prepare("SELECT FKimmagineProfilo FROM Utenti WHERE userId = ?");
$stmt1->bind_param("i", $userId);
$stmt1->execute();
$stmt1->bind_result($FKimmagineProfilo);
$stmt1->fetch();
$stmt1->close();

if ($FKimmagineProfilo) {
    // Recupera immagine dalla tabella Immagini
    $stmt2 = $conn->prepare("SELECT imageData, imageType FROM Immagini WHERE imageId = ?");
    $stmt2->bind_param("i", $FKimmagineProfilo);
    $stmt2->execute();
    $stmt2->bind_result($imageData, $mimeType);
    $stmt2->fetch();
    $stmt2->close();

    header("Content-Type: $mimeType");
    echo $imageData;
} else {
    // Immagine di default
    readfile("../img/default.png");
}
?>
