<?php
    include '../php_files/db_connection.php'; 

    // giochi visti recentemente
    $giochiVisualizzati = [];
    if (isset($_SESSION['userId'])) {
        $query = "SELECT p.productId, i.imageData, i.imageType
                FROM interazioni inter
                JOIN prodotti p ON inter.FKproductId = p.productId
                JOIN immagini i ON p.productId = i.FKproductId
                WHERE inter.FKuserId = ?
                AND inter.tipologia = 'visualizzato'
                GROUP BY p.productId
                ORDER BY inter.timestamp DESC
                LIMIT 5";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_SESSION['userId']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $giochiVisualizzati[] = [
                'productId' => $row['productId'],
                'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
            ];
        }
        $stmt->close();
    }
?>