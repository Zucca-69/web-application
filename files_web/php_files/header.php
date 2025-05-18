
<link rel="stylesheet" href="../css/header.css">
<link rel="stylesheet" href="../css/darkmode.css">
<script src="../js/dropdown_botton.js" defer></script>
<script src="../js/theme_toggle.js"></script>

<header>
    <div class="navbar-container">
        <!-- Logo a sinistra -->
        <div class="logo">
            <a href="index.php">
                <img src="../MEDIA/immagini/Logo_nobg.png" alt="Logo">
            </a>
        </div>

        <!-- Navigazione principale -->
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="news.php">News</a></li>
            <li><a href="catalogo.php">Catalogo</a></li>
            <li><a href="piattaforme.php">Piattaforme</a></li>
            <li><a href="categorie.php">Categorie</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="servizio-clienti.php">Servizio clienti</a></li>
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