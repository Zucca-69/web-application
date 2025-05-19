
<link rel="stylesheet" href="../css/header.css">
<link rel="stylesheet" href="../css/darkmode.css">
<script src="../js/dropdown_botton.js" ></script>
<script src="../js/theme_toggle.js"></script>

<?php
    include_once 'db_connection.php';

    // Recupero delle piattaforme uniche
    $resultPiattaforme = $conn->query("SELECT DISTINCT piattaforma FROM prodotti ORDER BY piattaforma ASC");
    $piattaforme = [];
    while ($row = $resultPiattaforme->fetch_assoc()) {
        if (!empty($row['piattaforma'])) {
            $piattaforme[] = $row['piattaforma'];
        }
    }

    // Recupero delle categorie
    $resultCategorie = $conn->query("
        SELECT DISTINCT c.categoryId, c.nome
        FROM categorie c
        JOIN appartenenze a ON c.categoryId = a.FKcategoryId
        ORDER BY c.nome ASC
    ");
    $categorie = [];
    while ($row = $resultCategorie->fetch_assoc()) {
        $categorie[] = $row;
    }
?>

<header>
    <div class="navbar-container">
        <!-- Logo a sinistra -->
        <div class="logo">
            <a href="index.php">
                <img src="../MEDIA/immagini/Logo.png" alt="Logo">
            </a>
        </div>

        <!-- Navigazione principale -->
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="news.php">News</a></li>
            <li><a href="catalogo.php">Catalogo</a></li>

            <!-- Dropdown Piattaforme -->
            <li class="dropdown">
                <button class="dropbtn">Piattaforme</button>
                <div class="dropdown-content">
                    <?php foreach ($piattaforme as $piattaforma): ?>
                        <a href="catalogo.php?piattaforma=<?= urlencode($piattaforma) ?>"><?= htmlspecialchars($piattaforma) ?></a>
                    <?php endforeach; ?>
                </div>
            </li>

            <!-- Dropdown Categorie -->
            <li class="dropdown">
                <button class="dropbtn">Categorie</button>
                <div class="dropdown-content">
                    <?php foreach ($categorie as $categoria): ?>
                        <a href="catalogo.php?categoryId=<?= $categoria['categoryId'] ?>"><?= htmlspecialchars($categoria['nome']) ?></a>
                    <?php endforeach; ?>
                </div>
            </li>

            <li><a href="contact.php">Contattaci</a></li>
            <li><a href="contact.php">Contattaci</a></li>
        </ul>

        <!-- Utente (login o profilo/carrello) -->
        <div class="user-section">
                <div class="dropdown">
                    <button class="dropbtn">
                        <!-- <img src="../MEDIA/immagini/manca-immagine-profilo.jpg" alt="Immagine profilo" class="profile-pic"> -->
                        <img src="../php_files/get_profile_img.php" alt="Immagine profilo" style="width:50px; height:50px;">

                    </button>
                    <div class="dropdown-content">
                        <a href="profilo.php">Profilo</a>
                        <a href="impostazioni.php">Impostazioni</a>
                        <a href="../php_files/logout.php">Logout</a>
                    </div>
                </div>

                <div class="cart-icon">
                    <a href="carrello.php">
                        <img src="../MEDIA/immagini/carrello.png" alt="Carrello">
                    </a>
                </div>
        </div>
    </div>
</header>
<div class="header-divider"></div>