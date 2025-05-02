<?php
	$link = new mysqli("localhost", "root", "vc-mob2-02", "rungamedb");

	$nome = mysqli_real_escape_string($link, "Uncharted: Drake's Fortune");
	$descrizione = mysqli_real_escape_string($link, "Uncharted: Drake's Fortune è un action-adventure dove Nathan Drake, cacciatore di tesori scaltro e ironico, cerca un tesoro legato a Sir Francis Drake. Esplorando un'isola sperduta, affronta mercenari e scopre un antico segreto, tra sparatorie, arrampicate e enigmi ambientali. Un mix di azione e esplorazione.");
	$prezzo = mysqli_real_escape_string($link, '11');
	$saga = mysqli_real_escape_string($link, 'Uncharted');
	$piattaforma = mysqli_real_escape_string($link, 'PS3');
	$quantitaDisponibile = mysqli_real_escape_string($link, '542');
	$dataUscita = mysqli_real_escape_string($link, '2007-11-19');
	$dataDisponibile = mysqli_real_escape_string($link, '2007-12-07');

	// inserisce i dati nella tabella prodotti
	$query = "INSERT INTO prodotti (nome, descrizione, prezzo, saga, piattaforma, quantitaDisponibile, dataUscita, dataDisponibile) 
	VALUES ('$nome', '$descrizione', '$prezzo', '$saga', '$piattaforma', '$quantitaDisponibile', '$dataUscita', '$dataDisponibile')";

	$result = mysqli_query($link, $query);
?>
