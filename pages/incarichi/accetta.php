<?php

session_start();

//echo $_SESSION['user'];

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';


echo "<h2> La gestione degli incarichi e' attualmente in fase di test and debug. Ci scusiamo per il disagio</h2>";


//$id=$_GET["id"];
$id=str_replace("'", "", $_GET['id']); //incarico

$data_inizio=$_POST["data_inizio"];
$hh=$_POST["hh_start"];
$mm=$_POST["mm_start"];

$time_preview= $data_inizio." ".$hh .":".$mm;
 
$parziale=$_POST["parziale"];

$note= str_replace("'", "''", $_POST["note"]);
$uo=$_POST["uo"];

echo "Incarico:".$id. "<br>";
echo "Time preview:".$time_preview. "<br>";
echo "Note:".$note. "<br>";
echo "Parziale:".$parziale. "<br>";

//exit;


$query= "UPDATE segnalazioni.t_incarichi SET time_preview='".$time_preview."' 
WHERE id=".$id.";";
echo $query."<br>";
//exit;
//$result=pg_query($conn, $query);



$query= "INSERT INTO segnalazioni.stato_incarichi(id_incarico, id_stato_incarico, parziale";

//values
$query=$query.") VALUES (".$id_incarico.", 2 , '".$parziale."'";

$query=$query.");";

echo $query."<br>";
//exit;
//$result=pg_query($conn, $query);



if ($note!=''){

	$query= "INSERT INTO segnalazioni.t_comunicazioni_incarichi(
	            id_incarico, testo)
	    VALUES (".$id.", '".$note."');";
	
	
	echo $query."<br>";
	//exit;
	//$result=pg_query($conn, $query);
}



$query= "INSERT INTO segnalazioni.t_storico_segnalazioni_in_lavorazione(id_segnalazione_in_lavorazione, log_aggiornamento";

//values
$query=$query.") VALUES (".$id.", ' L'incarico ".$id." � stato preso in carico da seguente unit� operativa: ".$uo." - <a class=\"btn btn-info\" href=\"dettagli_incarico.php?id=".$id."\"> Visualizza dettagli </a>'";

$query=$query.");";


echo $query."<br>";
//exit;
//$result=pg_query($conn, $query);


$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('segnalazioni','".$operatore ."', 'Incarico ".$id." preso in carico');";
echo $query_log."<br>";
//$result = pg_query($conn, $query_log);


exit;
header("location: ../dettagli_incarico.php?id=".$id);


?>
