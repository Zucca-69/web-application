<?php
session_start();
session_unset();
session_destroy();
header("Location: ../pagine/index.php"); // o "../index.php" dipende dalla tua struttura
exit();
?>
