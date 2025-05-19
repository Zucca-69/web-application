<?php
    include 'db_connection.php';

    $query = "SELECT nome, imageData, imageType, categoryId FROM categorie
                LEFT JOIN immagini ON categorie.categoryId = immagini.FKcategoryId";

    $rawResult = $conn->query($query);
            
    $categorie = [];
    $result = $rawResult->fetch_all(MYSQLI_ASSOC);
    foreach ($result as $row) {
        $base64 = base64_encode($row['imageData']);
        $infoCategorie[] = [
                'categoryImg' => "data:" . $row['imageType'] . ";base64," . $base64 ,
                'categoryName' => $row['nome'],
                'categoryId' => $row['categoryId']
        ];
    }
?>