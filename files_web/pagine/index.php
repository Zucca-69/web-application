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
            <!-- <img id="mainImage" class="slider-image" src="" alt="Immagine"> -->
            
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
                <a href='catalogo.php?categoria={$nome}'>
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

    <!-- Footer con informazioni sull'azienda -->
    <footer class="footer">
        <div class="footer-content">
            <h2>Chi Siamo</h2>
            <p>Siamo un team appassionato d'arte che si dedica a portare quadri unici e originali nelle case di tutto il mondo.
            La nostra missione è offrire opere di alta qualità, curate con amore e attenzione, per arricchire ogni spazio
            con bellezza ed emozione.</p>
    
            <p>Contattaci per qualsiasi informazione o curiosità! Siamo sempre felici di aiutarti.</p>
    
            <p>Email: info@rungame.it | Telefono: +39 123 456 789</p>
        </div>
    </footer>

</body>
</html>
