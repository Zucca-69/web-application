<?php
session_start();
require_once("db_connection.php");

// Query: prende le ultime 5 immagini con FKproductId, evitando duplicati per imageName
$stmt = $conn->prepare("
    SELECT i.imageData, i.imageType, i.FKproductId, p.piattaforma
    FROM Immagini i
    INNER JOIN (
        SELECT FKproductId, imageId AS max_id
        FROM Immagini
        WHERE FKproductId IS NOT NULL
        GROUP BY FKproductId
    ) latest ON i.imageId = latest.max_id
    INNER JOIN prodotti p ON i.FKproductId = p.productId
    GROUP BY p.productId
    ORDER BY i.imageId DESC
    LIMIT 5;


");

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imageData, $imageType, $productId, $piattaforma);

// Array per contenere immagini nel formato { src: ..., productId: ..., piattaforma: ... }
$immagini = [];

while ($stmt->fetch()) {
    $base64Image = "data:" . $imageType . ";base64," . base64_encode($imageData);
    $immagini[] = [
        "src" => $base64Image,
        "productId" => $productId,
        "piattaforma" => $piattaforma
    ];
}

$stmt->close();

// Invia JSON al client
header("Content-Type: application/json");
echo json_encode($immagini);
?>