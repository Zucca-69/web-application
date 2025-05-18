<link rel="stylesheet" href="../css/header.css">
<link rel="stylesheet" href="../css/darkmode.css">
<script src="../js/dropdown_botton.js" defer></script>
<script src="../js/theme_toggle.js"></script>

<header>
    <script>
        let userId = <?= json_encode($_SESSION['userId'] ?? null) ?>;
        console.log("User ID:", userId); // Debug
    </script>
    <div class="navbar-container">
        <!-- Logo a sinistra -->
        <div class="logo">
            <a href="index.php">
                <img src="../MEDIA/immagini/Logo.png" alt="Logo">
            </a>
        </div>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="catalogo.php">Catalogo</a></li>
            <li><a href="catalogo.php?piattaforma=">Piattaforme</a></li>
            <li><a href="catalogo.php?categoria=">Categorie</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="servizio-clienti.php">Servizio clienti</a></li>

            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 0): ?>
                <li><a href="add_prodotto.php">Aggiunta prodotto</a></li>
                <li><a href="../php_files/add_img.php">Aggiunta immagini</a></li>
            <?php endif; ?>
        </ul>

        <!-- Utente (login o profilo/carrello) -->
        <div class="user-section">
            <?php if (isset($_SESSION['userId'])): ?>
                <div class="dropdown">
                    <button class="dropbtn">
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
            <?php else: ?>
                <a class="auth-link" href="login.php">Accedi</a>
                <a class="auth-link" href="register.php">Registrati</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<div class="header-divider"></div>
