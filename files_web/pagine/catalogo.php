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

    /* layout a griglia responsive */
    .catalogo {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        padding: 20px 20%;
        justify-content: center;
    }


    .catalogo-item {
        width: 100%;
        background-color: #01cd01;
        border-radius: 15px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 10px;
        text-align: center;
        margin-bottom: 20px; /* Spazio tra i riquadri */
        transition: transform 0.2s;
    }

    /* link testuali disabilitati */
    .catalogo-item a {
        text-decoration: none;
        color: inherit;
        all: unset;
        display: block;
    }

    .catalogo-item img {
        width: 95%;
        height: auto;
        border-radius: 10px;
        border: 2px solid #ccc;
        transform: scale(1.02);
    }

    .sottotitolo {
        background-color: #01cd01;
        margin-top: 10px;
        font-weight: bold;
        text-decoration: none;
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
    <?php 
        include '../php_files/header_check.php'; 
        include '../php_files/db_connection.php'; 

        $i = 0;
        $numGiochiPagina = 25;

        $query = "SELECT p.productId, nome, i.imageData, i.imageType FROM prodotti p
                    JOIN immagini i ON p.productId = i.FKproductId
                    GROUP BY p.productId";
        $rawResult = $conn->query($query);

        $giochi = [];
        if ($rawResult && $rawResult->num_rows > 0) {
            while ($row = $rawResult->fetch_assoc()) {
                $giochi[] = [
                    'productId' => $row['productId'],
                    'nome' => $row['nome'],
                    'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                ];
            }
        } else {
            echo "errore query: " . $conn->error;
        }

        // chiudo la connessione al server una volta finite le query necessarie
        $conn -> close();
    ?>

    <div class="catalogo-title">CATALOGO</div>

        <div class="catalogo">
            <?php 
                foreach ($giochi as $gioco) {
                    $out = "<a href='mostra-prodotti.php?productId=" . $gioco['productId'] . "'>
                                <div class='catalogo-item'>
                                    <img src='" . $gioco['src'] . "' alt='Immagine'>
                                    <div class='sottotitolo'>" . $gioco['nome'] . "</div> 
                                </div>
                            </a>";
                    echo $out;
                }
            ?>
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