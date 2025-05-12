<?php
$servername = "localhost";
$username = "root"; //  user
$password = "vc-mob2-02"; // password di mysql
$dbname = "rungamedb"; // nome del database che hai creato

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
