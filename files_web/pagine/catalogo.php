<?php 
// Avvia la sessione per gestire login/logout
session_start(); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - Catalogo</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 10px;
        }
        
        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #333;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>

<?php include '../php_files/header_check.php'; ?>
<?php include '../php_files/db_connection.php'; ?>

<body>
    <?php 
        // Numero di giochi per pagina
        $numGiochiPagina = 20;
        $totalePagine = 3; // Numero fisso di pagine
        
        // Ottieni il numero di pagina corrente
        $paginaCorrente = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaCorrente < 1) $paginaCorrente = 1;
        if ($paginaCorrente > $totalePagine) $paginaCorrente = $totalePagine;
        
        // Calcola l'offset per la query SQL
        $offset = ($paginaCorrente - 1) * $numGiochiPagina;
        
        // Query per ottenere i giochi della pagina corrente
        $query = "SELECT p.productId, nome, i.imageData, i.imageType FROM prodotti p
                    JOIN immagini i ON p.productId = i.FKproductId
                    GROUP BY p.productId
                    LIMIT $numGiochiPagina OFFSET $offset";
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
            echo "Nessun gioco trovato.";
        }

        // chiudo la connessione al server una volta finite le query necessarie
        $conn->close();
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
    
    <!-- Paginazione -->
    <div class="pagination">
        <?php if ($paginaCorrente > 1): ?>
            <a href="?pagina=1">&laquo; Prima</a>
            <a href="?pagina=<?php echo $paginaCorrente - 1; ?>">&lsaquo; Precedente</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalePagine; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $paginaCorrente) echo 'class="active"'; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
        
        <?php if ($paginaCorrente < $totalePagine): ?>
            <a href="?pagina=<?php echo $paginaCorrente + 1; ?>">Successivo &rsaquo;</a>
            <a href="?pagina=<?php echo $totalePagine; ?>">Ultima &raquo;</a>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
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