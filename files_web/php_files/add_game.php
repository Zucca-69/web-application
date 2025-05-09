<?php
$link = new mysqli("localhost", "root", "root", "rungamedb");

$nome = mysqli_real_escape_string($link, "Squad");
$descrizione = mysqli_real_escape_string($link, "Sparatutto tattico in prima persona focalizzato su realismo e cooperazione. 50 vs 50 giocatori in mappe estese, con veicoli, costruzioni e comunicazione tra squadre. Include fazioni militari reali e ribelli.
");
$prezzo = mysqli_real_escape_string($link, '48.99');
$saga = mysqli_real_escape_string($link, "NULL");
$piattaforma = mysqli_real_escape_string($link, 'PC');
$quantitaDisponibile = mysqli_real_escape_string($link, '3');
$dataUscita = mysqli_real_escape_string($link, '2020-09-23');
$dataDisponibile = mysqli_real_escape_string($link, '2025-03-23');

// inserisce i dati nella tabella prodotti
$query = "INSERT INTO prodotti (nome, descrizione, prezzo, saga, piattaforma, quantitaDisponibile, dataUscita, dataDisponibile)
VALUES ('$nome', '$descrizione', '$prezzo', '$saga', '$piattaforma', '$quantitaDisponibile', '$dataUscita', '$dataDisponibile')";

$result = mysqli_query($link, $query);
?>