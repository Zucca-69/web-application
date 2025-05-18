<?php
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        
        $query = " SELECT p.productId, p.nome, p.prezzo, p.piattaforma, c.quantita
                        FROM interazioni i
                        JOIN prodotti p ON p.productId = i.FKproductId
                        JOIN carrelli c ON i.FKcartId = c.cartId
                        WHERE i.FKuserId = ?
                        AND i.tipologia = 'carrello'
                        AND i.FKcartId IS NOT NULL
                        ORDER BY i.timestamp DESC
            ";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $giochiCarrello = [];
        
        while ($row = $result->fetch_assoc()) {
            $giochiCarrello[] = [
                'productId' => $row['productId'],
                'nome' => $row['nome'],
                'prezzo' => $row['prezzo'],
                'piattaforma' => $row['piattaforma'],
                'quantita' => $row['quantita'],
            ];
        }
        
        $stmt->close();
        
    }
?>