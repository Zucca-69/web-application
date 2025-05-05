<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendita Quadri</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/galleria.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <style>
        body {
            background-color: #d3f9d8;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .immagini-gioco {
            width: 70%;
            padding-left: 20px;
            padding-top: 20px;
        }

        .immagine-principale img {
            width: 100%;
            height: auto;
            border: 2px solid #ccc;
            margin-bottom: 10px;
        }

        .miniature {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .miniature img {
            width: 30%;
            cursor: pointer;
            border: 1px solid #999;
            transition: transform 0.3s, border 0.3s;
        }

        .miniature img:hover {
            transform: scale(1.1);
            border: 2px solid #333;
        }

        .informazioni-gioco {
            width: 40%;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-top: 20px;
        }

        .riquadro {
            width: 100%;
            height: 100px;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            color: #333;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-left: 10%;
            cursor: pointer;
        }

        .riquadro:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .barra-richieste {
            display: none;
            margin-top: 10px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 20%;
            width: auto;
        }

        .barra-richieste ul {
            list-style: none;
            padding: 10px;
        }

        .barra-richieste ul li {
            margin: 10px 0;
        }

        .barra-richieste ul li a {
            text-decoration: none;
            color: #333;
            font-size: 12px;
            transition: color 0.3s;
        }

        .barra-richieste ul li a:hover {
            color: #01cd01;
        }

        .sezioni-contenitore {
            display: flex;
            flex-direction: column;
            gap: 30px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .sezione {
            width: 100%;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .sezione:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .etichetta-sezione {
            font-size: 20px;
            font-weight: bold;
            color: #222;
            margin-bottom: 15px;
        }

        .testo-descrizione {
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .sezione-img-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;

        }

        .sezione-img-container img {
            width: 22%;
            min-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #ccc;
            transition: transform 0.3s ease-in-out;
        }

        .sezione-img-container img:hover {
            transform: scale(1.1);
        }

        .sezione-titolo {
            width: 100%;
            height: 150px;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #333;
            margin-top: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .sezione-titolo h1 {
            margin: 0;
            font-size: 32px;
            color: #333;
        }

        .sezione-titolo:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .logo {
            padding: 10px;
        }

        .top-right-image,
        .top-right-carrello {
            position: absolute;
            top: 10px;
        }

        .top-right-image {
            right: 100px;
        }

        .top-right-carrello {
            right: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
            background-color: #f0f0f0;
            margin: 0;
        }

        nav ul li {
            padding: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
        }

        nav ul li a:hover {
            color: #01cd01;
        }
    </style>
</head>
<body>
    <?php 
        include '../php_files/header_check.php'; 
        include '../php_files/db_connection.php'; 

        $productId = $_GET['productId'];

        //info sul gioco
        $query = "SELECT * FROM prodotti WHERE productId = $productId";
        $rawResult = $conn -> query($query);
        $gameInfo = $rawResult->fetch_assoc();
    
        // immagini del gioco
        $query = "SELECT imageData, imageType FROM immagini WHERE FKproductId = $productId";
        $rawResult = $conn->query($query);
        
        $immagini = [];
        $result = $rawResult->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $row) {
            $base64 = base64_encode($row['imageData']);
            $immagini[] = "data:" . $row['imageType'] . ";base64," . $base64;
        }

        // cerco le diverse piattaforme del gioco
        $nome = $gameInfo['nome'];
        $query = "SELECT productId, piattaforma FROM prodotti WHERE nome = '" . $conn->real_escape_string($nome) . "'";
        $rawResult = $conn->query($query);
        
        $piattaforme = [];
        
        if ($rawResult && $rawResult->num_rows > 0) {
            while ($row = $rawResult->fetch_assoc()) {
                $piattaforme[] = [
                    'productId' => $row['productId'],
                    'piattaforma' => $row['piattaforma'],
                ];
            }
        } else {
            echo "errore query: " . $conn->error;
        }
        
        // controllo se il gioco fa parte di una saga
        $saga = $conn->real_escape_string($gameInfo['saga']);
        $giochiSaga = [];

        if (!empty($saga)) {
            $query = "SELECT p.productId, i.imageData, i.imageType
                    FROM prodotti p
                    JOIN immagini i ON p.productId = i.FKproductId
                    WHERE p.saga = '$saga' 
                    AND p.productId != '$productId'
                    GROUP BY p.productId";

            $rawResult = $conn->query($query);

            if ($rawResult && $rawResult->num_rows > 0) {
                while ($row = $rawResult->fetch_assoc()) {
                    $giochiSaga[] = [
                        'productId' => $row['productId'],
                        'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                    ];
                }
            } else {
                echo "errore query: " . $conn->error;
            }
        }

        // chiudo la connessione al server una volta finite le query necessarie
        $conn -> close();
    ?>
    
    <div class="container">
        <div class="immagini-gioco">
            <div class="immagine-principale">
                <img id="imgGrande" src="<?php echo $immagini[0]; ?>" alt="Immagine Grande">
            </div>
                
            <div class="miniature">
                <?php for ($i = 0; $i < 3 && isset($immagini[$i]); $i++): ?>
                    <img class="mini" src="<?php echo $immagini[$i]; ?>" alt="Miniatura <?php echo $i + 1; ?>">
                <?php endfor; ?>
            </div>
        </div>

        <div class="informazioni-gioco">

            <div class="riquadro">
                <p> 
                    <?php
                        echo $gameInfo['nome'] . '<br>' . $gameInfo['prezzo'] . '€';
                    ?>
                </p>
            </div>

            <!-- mostra la disponibilità di un prodotto -->
            <div class="riquadro">
                <p>
                    <?php
                        if ($gameInfo['quantitaDisponibile'] == 0 or is_null($gameInfo['quantitaDisponibile'])) {
                            echo 'Prodotto non disponibile';
                        } else if ($gameInfo['quantitaDisponibile'] > 10) {
                            echo 'Disponibilità immediata';
                        } else {
                            echo 'Disponibili solo ' . $gameInfo['quantitaDisponibile'];
                        }
                    ?>
                </p>
            </div>

            <!-- seleziona la piattaforma per il gioco -->
            <div class="riquadro" id="riquadro">
                <span>
                    Piattaforma: <?php echo $gameInfo['piattaforma']; ?>
                </span>
            </div>
                        
            <?php
                echo '<div id="barra-richieste" class="barra-richieste"><ul>';
                    if (count($piattaforme) > 1) {
                        $limite = min(5, count($piattaforme));
                        for ($i = 0; $i < $limite; $i++) {
                            $link = "mostra-prodotti.php?productId=" . $piattaforme[$i]['productId'];
                            $testo = htmlspecialchars($piattaforme[$i]['piattaforma'] ?? '');
                            echo "<li><a href=\"$link\">$testo</a></li>";
                        }
                    } else {
                        echo "<li>Siamo spiacenti: non ci sono altre piattaforme per questo contenuto</li>";
                    }
                echo '</ul></div>';
            ?>

        </div>
    </div>

    <!-- descrizione -->
    <div class="sezioni-contenitore">
        <div class="sezione">
            <div class="etichetta-sezione">DESCRIZIONE:</div>
            <p class="testo-descrizione">
                <?php
                    echo $gameInfo['descrizione'];
                ?>
            </p>
        </div>

        <!-- riquadro con la saga -->
        <?php 
            if ($saga != NULL && !empty($giochiSaga)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>SAGA:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiSaga as $giocoSaga) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoSaga['productId'] . "'>";
                    echo "<img src='" . $giocoSaga['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>

        <!-- riquadro per i correlati -->
        <?php 
            // TODO : aggiungere la query per i consigliati
            if ($saga != NULL && !empty($giochiSaga)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>CORRELATI:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiSaga as $giocoSaga) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoSaga['productId'] . "'>";
                    echo "<img src='" . $giocoSaga['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>

        <!-- riquadro per i consigliati -->
        <?php 
            // TODO : aggiungere la query per i consigliati
            if ($saga != NULL && !empty($giochiSaga)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>CONSIGLIATI PER TE:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiSaga as $giocoSaga) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoSaga['productId'] . "'>";
                    echo "<img src='" . $giocoSaga['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>
    </div>

    <script>
        // Mostra/nasconde la barra delle richieste
        document.addEventListener("DOMContentLoaded", function () {
            const riquadro = document.getElementById('riquadro');
            const barraRichieste = document.getElementById('barra-richieste');
            riquadro.addEventListener('click', function () {
                barraRichieste.style.display = (barraRichieste.style.display === "block") ? "none" : "block";
            });

            // Galleria click immagini
            const miniature = document.querySelectorAll('.mini');
            const imgGrande = document.getElementById('imgGrande');
            miniature.forEach(mini => {
                mini.addEventListener('click', () => {
                    imgGrande.src = mini.src;
                    imgGrande.alt = mini.alt;
                });
            });
        });
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <h2>Chi Siamo</h2>
            <p>
                Siamo un team appassionato d'arte che si dedica a portare quadri unici e originali nelle case di tutto il mondo.
                La nostra missione è offrire opere di alta qualità, curate con amore e attenzione, per arricchire ogni spazio
                con bellezza ed emozione.
            </p>
            
            <p>
                Contattaci per qualsiasi informazione o curiosità! Siamo sempre felici di aiutarti.
            </p>

            <p>
                Email: info@tuaazienda.it | Telefono: +39 123 456 789
            </p>
        </div>
    </footer>
</body>
</html>