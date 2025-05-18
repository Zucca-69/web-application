
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - Catalogo</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/catalogo.css">

</head>
<body>

    <?php 
    session_start(); 
    include '../php_files/header_check.php'; 
    include '../php_files/db_connection.php'; 

    // Filtro dinamico
    $condizioniFiltro = [];

    if (isset($_GET['categoryId'])) {
        $categoria = $conn->real_escape_string($_GET['categoryId']);
        $condizioniFiltro[] = "a.FKcategoryId = '$categoria'";
    }

    if (isset($_GET['news']) && $_GET['news'] == '1') {
        $condizioniFiltro[] = "p.dataUscita BETWEEN (NOW() - INTERVAL 1 MONTH) AND NOW()";
    }

    $whereClause = '';
    if (!empty($condizioniFiltro)) {
        $whereClause = "WHERE " . implode(" AND ", $condizioniFiltro);
    }

    // Calcola totale giochi
    $countQuery = "
        SELECT COUNT(DISTINCT p.nome) as totale
        FROM prodotti p
        JOIN appartenenze a ON p.productId = a.FKproductId
        $whereClause
    ";
    $result = $conn->query($countQuery);
    $row = $result->fetch_assoc();
    $totaleGiochi = (int)$row['totale'];

    // Impaginazione
    $giochiPerPagina = 20;
    $paginaCorrente = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
    $offset = ($paginaCorrente - 1) * $giochiPerPagina;
    $totalePagine = max(1, ceil($totaleGiochi / $giochiPerPagina));

    // Query finale con LIMIT
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
        while ($row = $rawResult->fetch_assoc()) {
            $giochi[] = [
                'productId' => $row['productId'],
                'piattaforma' => $row['piattaforma'],
                'nome' => $row['nome'],
                'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
            ];
        }
    } else {
        echo "<div class='sezione'><div class='testo-nessun-gioco'>Siamo spiacenti, non abbiamo prodotti che rispettano i tuoi parametri di ricerca.</div></div>";
    }

    $conn->close();
?>

    <div class="catalogo">
        <?php 
            foreach ($giochi as $gioco) {
                $out = "<a href='mostra-prodotti.php?productId=" . $gioco['productId'] . "&piattaforma=" . $gioco['piattaforma'] . "'>
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
    
<?php include '../php_files/footer.php'; ?>
</body>
</html>