<?php
session_start();
require_once("db_connection.php");

// Query: prende le ultime 5 immagini con FKproductId, evitando duplicati per imageName
$stmt = $conn->prepare("
    SELECT i.imageData, i.imageType, i.FKproductId
    FROM Immagini AS i
        INNER JOIN (
            SELECT imm.FKproductId, imm.imageId AS max_id
            FROM Immagini imm, prodotti p
            WHERE imm.FKproductId IS NOT NULL
            AND p.productId = imm.FKproductId
            GROUP BY imm.FKproductId
        ) AS latest ON i.imageId = latest.max_id
    ORDER BY i.imageId DESC
    LIMIT 5;

");

// SELECT i.imageData, i.imageType, p.productId FROM prodotti p
//                     JOIN immagini i ON p.productId = i.FKproductId
//                     GROUP BY p.productId

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imageData, $imageType, $productId);

// Array per contenere immagini nel formato { src: ..., productId: ... }
$immagini = [];

while ($stmt->fetch()) {
    $base64Image = "data:" . $imageType . ";base64," . base64_encode($imageData);
    $immagini[] = [
        "src" => $base64Image,
        "productId" => $productId
    ];
}

$stmt->close();

// Invia JSON al client
header("Content-Type: application/json");
echo json_encode($immagini);
?>
