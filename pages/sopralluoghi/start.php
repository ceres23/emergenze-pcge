<?php

session_start();

//echo $_SESSION['user'];

include explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php';


echo "<h2> La gestione dei sopralluoghi e' attualmente in fase di test and debug. Ci scusiamo per il disagio</h2>";


//$id=$_GET["id"];
$id=str_replace("'", "", $_GET['id']); //sopralluogo


echo "Sopralluogo:".$id. "<br>";


$query= "SELECT * FROM segnalazioni.v_sopralluoghi WHERE id=".$id.";";
$result=pg_query($conn, $query);
while($r = pg_fetch_assoc($result)) {
		$id_lavorazione=$r['id_lavorazione'];
		$uo=$r['descrizione_uo'];
}

//exit;


$query= "UPDATE segnalazioni.t_sopralluoghi SET time_start=now() 
WHERE id=".$id.";";
echo $query."<br>";
//exit;
$result=pg_query($conn, $query);





$query= "INSERT INTO segnalazioni.t_storico_segnalazioni_in_lavorazione(id_segnalazione_in_lavorazione, log_aggiornamento";

//values
$query=$query.") VALUES (".$id_lavorazione.", ' Sopralluogo ".$id." attualmente in corso (".$uo." ) - <a class=\"btn btn-info\" href=\"dettagli_sopralluogo.php?id=".$id."\"> Visualizza dettagli </a>'";

$query=$query.");";


echo $query."<br>";
//exit;
$result=pg_query($conn, $query);


$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('segnalazioni','".$operatore ."', 'Sopralluogo ".$id." in corso');";
echo $query_log."<br>";
$result = pg_query($conn, $query_log);


//exit;
header("location: ../dettagli_sopralluogo.php?id=".$id);


?>
