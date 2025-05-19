<?php
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        
        // ottengo tutti i prodotti attualmente nel carrello del cliente loggato
        $query = "SELECT p.productId, p.nome, p.prezzo, i.FKpiattaforma, c.quantita, p.quantitaDisponibile AS disponibilita
                            FROM interazioni i
                            JOIN prodotti p ON p.productId = i.FKproductId
                            JOIN carrelli c ON i.FKcartId = c.cartId
                            WHERE i.FKuserId = ?
                            AND i.tipologia = 'carrello'
                            AND i.FKcartId IS NOT NULL
                            GROUP BY p.productId
                            ORDER BY i.timestamp DESC";

        // prepared stmt
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
                'piattaforma' => $row['FKpiattaforma'],
                'quantita' => $row['quantita'],
                'disponibilita' => $row['disponibilita']
            ];
        }
        
        $stmt->close();
        
    }
?>