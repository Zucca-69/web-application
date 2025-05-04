<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalogo</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">

    <style>
        
        .catalogo-title {
            text-align: center;
            margin-top: 30px;
            font-size: clamp(24px, 5vw, 48px);
            color: #01cd01;
        }

        .galleria {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .galleria-item {
            width: 300px;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .galleria-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            border: 2px solid #ccc;
        }

        .sezione-sotto-immagine {
            background-color: #01cd01;
            margin-top: 10px;
            font-weight: bold;
            color: #333;
            padding: 10px;
            border-radius: 10px;
            word-wrap: break-word;
            min-height: 50px;
        }

        .logo, .top-right-image, .top-right-carrello {
            margin: 10px;
        }

        .top-right-image, .top-right-carrello {
            position: absolute;
            top: 10px;
        }

        .top-right-image {
            right: 60px;
        }

        .top-right-carrello {
            right: 10px;
        }
    </style>
</head>

<body>

    <?php include '../php_files/header_check.php'; ?>

    <div class="catalogo-title">CATALOGO</div>

    <div class="galleria">
        <div class="galleria-item">
            <img src="../MEDIA/immagini/sparatutto2021.jpg.800x400_q70_crop-smart_upscale-True.jpg" alt="Sparatutto">
            <div class="sezione-sotto-immagine">Fortnite.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Sport">
            <div class="sezione-sotto-immagine">Fortnite2.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/sparatutto2021.jpg.800x400_q70_crop-smart_upscale-True.jpg" alt="Sparatutto">
            <div class="sezione-sotto-immagine">Fortnite.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Sport">
            <div class="sezione-sotto-immagine">Fortnite2.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/sparatutto2021.jpg.800x400_q70_crop-smart_upscale-True.jpg" alt="Sparatutto">
            <div class="sezione-sotto-immagine">Fortnite.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Sport">
            <div class="sezione-sotto-immagine">Fortnite2.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/sparatutto2021.jpg.800x400_q70_crop-smart_upscale-True.jpg" alt="Sparatutto">
            <div class="sezione-sotto-immagine">Fortnite.</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Sport">
            <div class="sezione-sotto-immagine">Fortnite2.</div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <h2>Chi Siamo</h2>
            <p>Siamo un team appassionato d'arte che si dedica a portare quadri unici e originali nelle case di tutto il mondo.
            La nostra missione è offrire opere di alta qualità, curate con amore e attenzione, per arricchire ogni spazio
            con bellezza ed emozione.</p>
            <p>Contattaci per qualsiasi informazione o curiosità! Siamo sempre felici di aiutarti.</p>

            <p>Email: info@tuaazienda.it | Telefono: +39 123 456 789</p>
        </div>
    </footer>

</body>
</html>
