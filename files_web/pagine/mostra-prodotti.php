<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RunGame</title>

    <!-- fogli di stile -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/categorie.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/mostra-prodotti.css">

    <!-- scripts -->
    <script src="../js/seleziona_quantita.js" defer></script>
    <script src="../js/product_functions.js" defer></script>
</head>
<body>
    <?php 
        // setup della pagina
        session_start();
        include '../php_files/db_connection.php';
        include '../php_files/cart_actions_handler.php'; 
        include '../php_files/header_check.php'; 
        include '../php_files/get_history.php';
 
        $productId = $_GET['productId'];
        $piattaforma = $_GET['piattaforma'] ;

        // se l'utente è loggato, aggiungi il gioco alla cronologia e controlla se il prodotto è già nel carrello
        if (isset($_SESSION['userId'])) {
            $query = "INSERT INTO interazioni (FKuserId, FKproductId, FKcartId, tipologia, timestamp) 
                    VALUES (?, ?, NULL, 'visualizzato', NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $_SESSION['userId'], $productId);
            $stmt->execute();
            $stmt->close();

            $qtaCarello = 0;
            $inCart = false;

            // controllo se il prodotto è già nel carrello dell'utente
            $query = "SELECT c.quantita 
                    FROM interazioni i
                    JOIN carrelli c ON i.FKcartId = c.cartId
                    WHERE i.tipologia = 'carrello'
                    AND i.FKuserId = ?
                    AND i.FKproductId = ?

                    ORDER BY i.timestamp DESC
                    LIMIT 1";
            
            // prepared statement per il carrello dell'utente
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $_SESSION['userId'], $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            
            if ($result->num_rows > 0) {
                $cartItem = $result->fetch_assoc();
                $qtaCarello = $cartItem['quantita'];
                $inCart = true;
            }
            $stmt->close();
        }

        // info sul gioco selezionato
        $gameInfo = [];
        $immagini = [];
        
        $query = "SELECT p.*, i.imageData, i.imageType 
                FROM prodotti p
                LEFT JOIN immagini i ON p.productId = i.FKproductId
                WHERE p.productId = ?";

        // prepared statement le info del gioco
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            if (empty($gameInfo)) {
                $gameInfo = $row;
            }
            if (!empty($row['imageData'])) {
                $immagini[] = "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData']);
            }
        }
        $stmt->close();

        // cerco le diverse piattaforme del gioco
        $nome = $gameInfo['nome'];
        $query = "SELECT productId, piattaforma FROM prodotti WHERE nome = '" . $conn->real_escape_string($nome) . "';";
        $rawResult = $conn->query($query);
        
        $giochiPiattaforme = [];
        
        if ($rawResult && $rawResult->num_rows > 0) {
            while ($row = $rawResult->fetch_assoc()) {
                $giochiPiattaforme[] = [
                    'productId' => $row['productId'],
                    'piattaforma' => $row['piattaforma'],
                ];
            }
        } else {
            echo "errore query: " . $conn->error;
        }

        // ottieni i giochi della saga
        $saga = $conn->real_escape_string($gameInfo['saga']);
        $giochiSaga = [];
        if (!empty($saga)) {
            $query = "SELECT p.productId, i.imageData, i.imageType, p.piattaforma
                    FROM prodotti p
                    JOIN immagini i ON p.productId = i.FKproductId
                    WHERE p.saga = ? 
                    AND p.productId != ?
                    GROUP BY p.productId
                    ORDER BY RAND()";

            // prepared statement per giochi della stessa saga
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $gameInfo['saga'], $productId);
            $stmt->execute();
            $rawResult = $stmt->get_result();
            
            while ($row = $rawResult->fetch_assoc()) {
                $giochiSaga[] = [
                    'productId' => $row['productId'],
                    'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData']),
                    'piattaforma' => $row['piattaforma']
                ];
            }
            $stmt->close();
        }

        // giochi simili per categoria
        $giochiConsigliati = [];
        $query = "SELECT p.productId, p.nome, i.imageData, i.imageType, p.piattaforma
                FROM Prodotti p
                JOIN Appartenenze a ON p.productId = a.FKproductId
                JOIN Immagini i ON p.productId = i.FKproductId
                WHERE a.FKcategoryId IN (
                    SELECT FKcategoryId
                    FROM Appartenenze
                    WHERE FKproductId = ?
                )
                AND p.productId != ?
                AND (p.saga IS NULL OR p.saga != ?)
                GROUP BY p.productId
                ORDER BY RAND()
                LIMIT 5";

        // prepared statement per giochi della stessa categorie
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $productId, $productId, $gameInfo['saga']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $giochiConsigliati[] = [
                'productId' => $row['productId'],
                'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData']),
                'piattaforma' => $row['piattaforma']
                
            ];
        }
        $stmt->close();

        $conn->close();

    ?>
   
    <!-- immagini a sinistra -->
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
            <!-- titolo e prezo -->
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

            <!-- azioni sul carrello -->
            <?php if (isset($_SESSION['userId'])) : ?>
                <!-- per utenti loggati -->
                <!-- cabia qta -->
                <?php if ($inCart) : ?>
                    <div class="riquadro">
                        <div class="quantita-container">
                            <div class="quantita-text">Quantità nel carrello</div>
                            <div class="quantita-btn-container">
                                <form method="post">
                                    <input type="hidden" name="cart_action" value="update">
                                    <input type="hidden" name="productId" value="<?= $productId ?>">
                                    <input type="hidden" name="piattaforma" value="<?= $piattaforma ?>">
                                    <input type="hidden" name="redirect" value="mostra-prodotti.php?productId=<?= $productId ?>&piattaforma=<?= $piattaforma ?>">
                                    <button type="button" onclick="updateCart(-1)">−</button>
                                    <span id="quantita"><?= $qtaCarello ?></span>
                                    <button type="button" onclick="updateCart(1)">+</button>
                                    <button type="button" onclick="removeFromCart(<?= $productId ?>, '<?= $piattaforma ?>')">Rimuovi</button>
                                    <input type="hidden" name="quantity" id="quantityInput" value="<?= $qtaCarello ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- utente loggato che non ha il prodotto nel carrello -->
                    <div class="riquadro">
                        <button id="addToCartBtn" class="quantita-text" 
                                data-product-id="<?= $productId ?>" 
                                data-piattaforma="<?= $piattaforma ?>">
                            Aggiungi al carrello
                        </button>
                    </div>
                <?php endif ?>
                <!-- utente non loggato -->
                <?php else : ?>
                    <div class="riquadro">
                        <a href="login.php">Accedi per aggiungere un prodotto al carrello!</a>
                    </div>
            <?php endif ?>

            <!-- seleziona la piattaforma per il gioco -->
            <div class="riquadro" id="riquadro">
                <span>
                    Piattaforma: <?php echo $piattaforma; ?>
                </span>
            </div>
                        
            <?php
                echo '<div id="barra-richieste" class="barra-richieste"><ul>';
                    // mostra tutte le piattaforme per quel gioco
                    if (count($giochiPiattaforme) > 1) {
                    foreach ($giochiPiattaforme as $giocoPiattaforma) {
                        echo "<li><a href='mostra-prodotti.php?productId=" . $giocoPiattaforma['productId'] . "&piattaforma=" . $giocoPiattaforma['piattaforma'] ."'>" . $giocoPiattaforma['piattaforma'] . "</a></li>";
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
                    // TODO : fixare la codifica del bd, guarda chatGPT moka
                    // https://chatgpt.com/c/6821a003-12b4-800b-b594-a11fcc2b18ac
                    echo htmlspecialchars($gameInfo['descrizione']);
                ?>
            </p>
        </div>

        <?php
            // riquadro con la saga
            if ($saga != "NULL" && !empty($giochiSaga)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>SAGA:</div>
                    <div class='sezione-img-container'>";

            foreach ($giochiSaga as $giocoSaga) {
                echo "<a href='mostra-prodotti.php?productId=" . $giocoSaga['productId'] . "&piattaforma=" . $giocoSaga['piattaforma'] . "'>";
                echo "<img src='" . $giocoSaga['src'] . "' alt='Gioco saga'>";
                echo "</a>";
            }

                echo "</div></div>";
            }

            // riquadro per i correlati
            if (!empty($giochiConsigliati)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>GIOCHI CORRELATI:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiConsigliati as $giocoConsigliato) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoConsigliato['productId'] . "&piattaforma=" . $giocoConsigliato['piattaforma'] . "'>";
                    echo "<img src='" . $giocoConsigliato['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }


                echo "</div></div>";
            }

            // riquadro per la cronologia
            if (!empty($giochiVisualizzati)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>VISUALIZZATI IN PRECEDENZA:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiVisualizzati as $giocoVisualizzato) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoVisualizzato['productId'] . "&piattaforma=" . $giocoVisualizzato['piattaforma'] . "'>";
                    echo "<img src='" . $giocoVisualizzato['src'] . "' alt='Gioco'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>
    </div>

    <!-- Footer -->
<?php include '../php_files/footer.php'; ?>
</body>
</html>