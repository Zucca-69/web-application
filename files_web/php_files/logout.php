<?php
session_start();
session_unset();
session_destroy();
?>
    <script>
        // Reimposta il tema su chiaro (di default) eliminando 'dark-mode' e aggiornando localStorage
        window.onload = () => {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
            window.location.href = '../pagine/index.php';
        };
    </script>
