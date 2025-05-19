<?php 
// Avvia la sessione per gestire login/logout
session_start(); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - Home</title>
    <!-- collegamento dei file CSS globali + specifici -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/categorie.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <script src="../js/slider_addimage.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>

<?php include '../php_files/header_check.php'; ?>

<body>
    <main>

        <!-- Contenitore dello slider -->
        <div class="image-slider">
            <!-- Freccia a sinistra -->
            <div class="slider-arrow arrow-left" onclick="cambiaImmagine(-1)">&#8592;</div>
            
            <!-- Immagine principale dello slider -->
            
            
            <!-- Freccia a destra -->
            <div class="slider-arrow arrow-right" onclick="cambiaImmagine(1)">&#8594;</div>
        </div>

        <!-- Contenitore dei pallini di navigazione -->
        <div class="dots-container" id="dots-container">
            <!-- Pallini generati dinamicamente -->
        </div>


    
    <?php 
        include "../php_files/get_gategory_img.php";   

        // immagine per ogni categoria
        echo "<div class='categorie'>";
        foreach ($infoCategorie as $c) {
            $nome = urlencode($c['categoryName']);
            echo "
                <a href='catalogo.php?categoryId={$c['categoryId']}'>
                    <div class='categorie-item'>
                        <img src='{$c['categoryImg']}' alt='Immagine {$c['categoryName']}'>
                        <div class='testo'>{$c['categoryName']}</div>
                    </div>
                </a>
            ";
        }
        echo "</div>";
    ?>
    </main>

<?php include '../php_files/footer.php'; ?>
</body>
</html>
