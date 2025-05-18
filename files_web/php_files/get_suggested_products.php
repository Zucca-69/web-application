<?php
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    
    // Query to get recommended products with their first image
    $recommendationQuery = "
        SELECT 
            p.productId, 
            p.nome, 
            p.prezzo, 
            p.piattaforma,
            (
                -- seleziono la prima immagine del gioco
                SELECT CONCAT('data:', i2.imageType, ';base64,', TO_BASE64(i2.imageData))
                FROM immagini i2 
                WHERE i2.FKproductId = p.productId 
                LIMIT 1
            ) AS productImage
        FROM 
            prodotti p
        INNER JOIN 
            Appartenenze a ON p.productId = a.FKproductId
        INNER JOIN (
            -- controllo le tre categorie più visulizzate dall'utente
            SELECT 
                a2.FKcategoryId,
                COUNT(*) AS view_count
            FROM 
                interazioni i
            INNER JOIN 
                Appartenenze a2 ON i.FKproductId = a2.FKproductId
            WHERE 
                i.FKuserId = ? 
                AND i.tipologia = 'visualizzato'
            GROUP BY 
                a2.FKcategoryId
            ORDER BY 
                view_count DESC
            LIMIT 3
        ) AS top_categories ON a.FKcategoryId = top_categories.FKcategoryId
        LEFT JOIN (
            -- controllo quali prodotti sono già stati acquistati dall'utente
            SELECT DISTINCT 
                FKproductId
            FROM 
                interazioni
            WHERE 
                FKuserId = ? 
                AND tipologia = 'acquistato'
        ) AS purchased_products ON p.productId = purchased_products.FKproductId
        WHERE 
            purchased_products.FKproductId IS NULL  -- Only products not purchased
        GROUP BY 
            p.productId
        ORDER BY 
            COUNT(*) DESC
        LIMIT 5;
    ";
    
    $stmt = $conn->prepare($recommendationQuery);
    $stmt->bind_param("ii", $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $giochiConsigliati = [];
    while ($row = $result->fetch_assoc()) {
        $giochiConsigliati[] = [
            'productId' => $row['productId'],
            'nome' => $row['nome'],
            'prezzo' => $row['prezzo'],
            'piattaforma' => $row['piattaforma'],
            'src' => $row['productImage'] // This contains the base64 encoded image
        ];
    }
    $stmt->close();
}

?>