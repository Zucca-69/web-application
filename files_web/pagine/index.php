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
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/categorie.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>

<?php include '../php_files/header.php'; ?>

<body>
    <main>

    <!-- Contenitore dello slider -->
    <div class="image-slider">
        <!-- Freccia a sinistra -->
        <div class="slider-arrow arrow-left" onclick="cambiaImmagine(-1)">&#8592;</div>
        
        <!-- Immagine principale dello slider -->
        <img id="mainImage" class="slider-image" src="../MEDIA/immagini/12c39f5c-bf65-4943-866a-5c585d075038.jpeg" alt="Immagine">
        
        <!-- Freccia a destra -->
        <div class="slider-arrow arrow-right" onclick="cambiaImmagine(1)">&#8594;</div>
    </div>

    <!-- Contenitore dei pallini di navigazione -->
    <div class="dots-container">
        <span class="dot" onclick="cambiaImmagine(0)"></span> <!-- Pallino 1 -->
        <span class="dot" onclick="cambiaImmagine(1)"></span> <!-- Pallino 2 -->
        <span class="dot" onclick="cambiaImmagine(2)"></span> <!-- Pallino 3 -->
    </div>

    <script>
        // Array di immagini per lo slider
        const immagini = [
          "../MEDIA/immagini/12c39f5c-bf65-4943-866a-5c585d075038.jpeg",
          "../MEDIA/immagini/lastchanceplay_4432243b.jpg",
          "../MEDIA/immagini/GOWR_Review_Screenshot_13.jpg"
        ];

        let indiceCorrente = 0;  // Indice per la posizione dell'immagine corrente

        // Funzione per cambiare immagine quando si clicca sulle frecce
        function cambiaImmagine(direzione) {
            const imgElement = document.getElementById('mainImage');  // Riferimento all'immagine corrente
            const dots = document.querySelectorAll('.dot');  // Riferimento ai pallini

            // Fase di dissolvenza dell'immagine
            imgElement.style.opacity = 0;

            // Dopo la dissolvenza, cambia immagine e riapri l'immagine con dissolvenza
            setTimeout(() => {
                indiceCorrente = (indiceCorrente + direzione + immagini.length) % immagini.length;  // Cambia l'indice dell'immagine
                imgElement.src = immagini[indiceCorrente];  // Imposta la nuova immagine

                // Fase di riapertura (fade-in)
                imgElement.style.opacity = 1;

                // Aggiorna i pallini di navigazione
                aggiornaPallini();
            }, 300); // Tempo della dissolvenza
        }

        // Funzione per aggiornare lo stato dei pallini (attivo o inattivo)
        function aggiornaPallini() {
            const dots = document.querySelectorAll('.dot');  // Ottieni tutti i pallini
            dots.forEach((dot, index) => {
                if (index === indiceCorrente) {  // Se il pallino è quello attivo
                    dot.classList.add('active');  // Aggiungi la classe 'active'
                } else {
                    dot.classList.remove('active');  // Rimuovi la classe 'active' per gli altri
                }
            });
        }

        // Inizializza il pallino attivo al primo caricamento della pagina
        aggiornaPallini();
    </script>

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
