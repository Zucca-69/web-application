<?php
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        
        $cartQuery = "
            SELECT 
                p.productId,
                p.nome,
                p.prezzo,
                p.piattaforma,
                c.quantita AS cartquantita,
                (
                    SELECT CONCAT('data:', i.imageType, ';base64,', TO_BASE64(i.imageData))
                    FROM immagini i 
                    WHERE i.FKproductId = p.productId 
                    LIMIT 1
                ) AS productImage
            FROM 
                prodotti p
            JOIN 
                interazioni i ON p.productId = i.FKproductId
            JOIN 
                carrelli c ON i.FKcartId = c.cartId
            WHERE 
                i.FKuserId = ?
                AND i.tipologia = 'carrello'
                AND i.FKcartId IS NOT NULL
            ORDER BY 
                i.timestamp DESC
        ";
        
        $stmt = $conn->prepare($cartQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $cartItems = [];
        
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = [
                'productId' => $row['productId'],
                'nome' => $row['nome'],
                'prezzo' => $row['prezzo'],
                'piattaforma' => $row['piattaforma'],
                'quantita' => $row['cartquantita'],
                'image' => $row['productImage'],
            ];
        }
        
        $stmt->close();
        
    }
?>