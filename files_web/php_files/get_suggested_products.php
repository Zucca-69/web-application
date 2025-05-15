<?php
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    
    // Query to get recommended products with just their first image
    $recommendationQuery = "
        SELECT 
            p.productId,
            p.nome,
            p.prezzo,
            (
                SELECT CONCAT('data:', i.imageType, ';base64,', TO_BASE64(i.imageData))
                FROM immagini i 
                WHERE i.FKproductId = p.productId 
                LIMIT 1
            ) AS firstImage,
            (
                (COUNT(DISTINCT v.FKproductId) * 0.4) + -- User views
                (COUNT(DISTINCT s.user_id) * 0.3) +    -- Similar users
                (c.popularity_score * 0.2) +           -- Category popularity
                (RAND() * 0.1)                         -- Random factor
            ) AS recommendation_score
        FROM 
            prodotti p
        LEFT JOIN 
            interazioni v ON p.productId = v.FKproductId AND v.FKuserId = ? AND v.tipologia = 'visualizzato'
        LEFT JOIN (
            SELECT DISTINCT 
                i2.FKuserId AS user_id,
                i2.FKproductId
            FROM 
                interazioni i1
            JOIN 
                interazioni i2 ON i1.FKproductId = i2.FKproductId AND i2.tipologia = 'acquistato'
            WHERE 
                i1.FKuserId = ? 
                AND i1.tipologia = 'visualizzato'
                AND i2.FKuserId != ?
        ) s ON p.productId = s.FKproductId
        LEFT JOIN (
            SELECT 
                a.FKcategoryId,
                COUNT(*) * 1.0 / (SELECT COUNT(*) FROM Appartenenze WHERE FKcategoryId = a.FKcategoryId) AS popularity_score
            FROM 
                Appartenenze a
            JOIN 
                interazioni i ON a.FKproductId = i.FKproductId
            WHERE 
                i.FKuserId = ?
            GROUP BY 
                a.FKcategoryId
        ) c ON p.productId IN (SELECT FKproductId FROM Appartenenze WHERE FKcategoryId = c.FKcategoryId)
        WHERE 
            p.productId NOT IN (
                SELECT FKproductId 
                FROM interazioni 
                WHERE FKuserId = ? AND tipologia = 'acquistato'
            )
        GROUP BY 
            p.productId, p.nome, p.prezzo
        ORDER BY 
            recommendation_score DESC
        LIMIT 5
    ";
    
    $stmt = $conn->prepare($recommendationQuery);
    $stmt->bind_param("iiiii", $userId, $userId, $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $giochiConsigliati = [];
    while ($row = $result->fetch_assoc()) {
        $giochiConsigliati[] = [
            'productId' => $row['productId'],
            'nome' => $row['nome'],
            'prezzo' => $row['prezzo'],
            'image' => $row['firstImage'], // Just the first image
            'score' => $row['recommendation_score']
        ];
    }
    $stmt->close();
}
?>