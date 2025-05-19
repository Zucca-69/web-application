<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - Catalogo</title>
    
    <!-- Link ai fogli di stile CSS -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/catalogo.css">

</head>
<body>

    <?php 
    session_start();  // Avvia la sessione per gestire login/utente
    include '../php_files/header_check.php';  // Include header con eventuale controllo utente loggato
    include '../php_files/db_connection.php';  // Connessione al database

    // Array che conterrà le condizioni della clausola WHERE per i filtri dinamici
    $condizioniFiltro = [];

    // * * filtro per categoria
    // Se è presente il parametro categoryId nella query string, aggiungo filtro categoria
    if (isset($_GET['categoryId'])) {
        $categoria = $conn->real_escape_string($_GET['categoryId']);  // Sanitizzo input
        $condizioniFiltro[] = "a.FKcategoryId = '$categoria'";
        // TODO : aggiungere prepared statement
        // ? è sicuro dall'injection? 
    }

    // * * filtro per piattaforma
    if (isset($_GET['piattaforma'])) {
        $categoria = $conn->real_escape_string($_GET['piattaforma']);  // ? Sanitizzo input
        $condizioniFiltro[] = "p.piattaforma = '$categoria'";
    }

    // Costruisco la clausola WHERE concatenando con AND le condizioni
    $whereClause = '';
    if (!empty($condizioniFiltro)) {
        $whereClause = "WHERE " . implode(" AND ", $condizioniFiltro);
    }

    // Query per contare il totale dei giochi che rispettano i filtri, usando DISTINCT per nome unico
    $countQuery = "
        SELECT COUNT(DISTINCT p.nome) as totale
        FROM prodotti p
        JOIN appartenenze a ON p.productId = a.FKproductId
        $whereClause
    ";
    $result = $conn->query($countQuery);
    $row = $result->fetch_assoc();
    $totaleGiochi = (int)$row['totale'];  // Salvo il totale dei giochi

    // Configuro la paginazione
    $giochiPerPagina = 20;  // Numero di giochi per pagina
    $paginaCorrente = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;  // Pagina corrente, almeno 1
    $offset = ($paginaCorrente - 1) * $giochiPerPagina;  // Calcolo offset per LIMIT
    $totalePagine = max(1, ceil($totaleGiochi / $giochiPerPagina));  // Calcolo numero totale pagine

    // Query finale per ottenere i giochi con le immagini, applicando filtri e paginazione
    $query = "
        SELECT MIN(p.productId) as productId, p.nome, p.piattaforma, i.imageData, i.imageType
        FROM prodotti p
        JOIN immagini i ON p.productId = i.FKproductId
        JOIN appartenenze a ON p.productId = a.FKproductId
        $whereClause
        GROUP BY p.nome
        LIMIT $giochiPerPagina OFFSET $offset
    ";

    $rawResult = $conn->query($query);

    $giochi = [];
    if ($rawResult && $rawResult->num_rows > 0) {
        // Ciclo i risultati e preparo un array con i dati da mostrare
        while ($row = $rawResult->fetch_assoc()) {
            $giochi[] = [
                'productId' => $row['productId'],
                'piattaforma' => $row['piattaforma'],
                'nome' => $row['nome'],
                'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData']) // Immagine codificata in base64
            ];
        }
    } else {
        // Se non ci sono risultati, mostro un messaggio all’utente
        echo "<div class='sezione'><div class='testo-nessun-gioco'>Siamo spiacenti, non abbiamo prodotti che rispettano i tuoi parametri di ricerca.</div></div>";
    }

    $conn->close(); // Chiudo la connessione al DB
?>

    <div class="catalogo">
        <?php 
            // Ciclo e stampo ogni gioco come blocco con immagine e nome linkato
            foreach ($giochi as $gioco) {
                echo "<div class='catalogo-item'>
                    <a href='mostra-prodotti.php?productId=" . $gioco['productId'] . "&piattaforma=" . $gioco['piattaforma'] . "'>
                        <img src='" . $gioco['src'] . "' alt='Immagine'>
                        <div class='sottotitolo'>" . $gioco['nome'] . "</div>
                    </a>
                </div>";
            }
        ?>
    </div>
    
    <!-- Sezione di paginazione -->
    <div class="pagination">
        <?php if ($paginaCorrente > 1): ?>
            <a href="?pagina=1">&laquo; Prima</a> <!-- Link alla prima pagina -->
            <a href="?pagina=<?php echo $paginaCorrente - 1; ?>">&lsaquo; Precedente</a> <!-- Link pagina precedente -->
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalePagine; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $paginaCorrente) echo 'class="active"'; ?>>
                <?php echo $i; ?> <!-- Link pagine numerate -->
            </a>
        <?php endfor; ?>
        
        <?php if ($paginaCorrente < $totalePagine): ?>
            <a href="?pagina=<?php echo $paginaCorrente + 1; ?>">Successivo &rsaquo;</a> <!-- Link pagina successiva -->
            <a href="?pagina=<?php echo $totalePagine; ?>">Ultima &raquo;</a> <!-- Link ultima pagina -->
        <?php endif; ?>
    </div>
    
<?php include '../php_files/footer.php'; ?> <!-- Footer comune -->
</body>
</html>
