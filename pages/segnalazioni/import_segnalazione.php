<?php

session_start();

include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

//$id=$_GET["id"];
$id=str_replace("'", "", $id);

echo "La gestione della segnalazione e' attualmente in fase di sviluppo. Ci scusiamo per il disagio<br>";
#segnalante

$query_max= "SELECT max(id) FROM segnalazioni.t_segnalanti;";
$result_max = pg_query($conn, $query_max);
while($r_max = pg_fetch_assoc($result_max)) {
	if ($r_max["max"]>0) {
		$id_segnalante=$r_max["max"]+1;
	} else {
		$id_segnalante=1;	
	}
}

echo $id_segnalante;
echo "<br>";


$query= "INSERT INTO segnalazioni.t_segnalanti( id, id_tipo_segnalante, nome_cognome";
if ($_POST["altro"]!=''){
	$query= $query .", altro_tipo";
}
if ($_POST["telefono"]!=''){
	$query= $query .", telefono";
}
if ($_POST["note_segnalante"]!=''){
	$query= $query .", note";
}
//values
$query=$query.") VALUES (".$id_segnalante.", ".$_POST["tipo_segn"].", '".$_POST["nome"]."' ";
if ($_POST["altro"]!=''){
	$query= $query .", '".$_POST["altro"]."'";
}
if ($_POST["telefono"]!=''){
	$query= $query .", '".$_POST["telefono"]."'";
}
if ($_POST["note_segnalante"]!=''){
	$query= $query .", '".$_POST["note_segnalante"]."'";
}

$query=$query.");";

echo $query;
//pg_query($conn, $query);

exit;




$data_inizio=$_POST["data_inizio"].' '.$_POST["hh_start"].':'.$_POST["mm_start"];
$data_fine=$_POST["data_fine"].' '.$_POST["hh_end"].':'.$_POST["mm_end"];



//$d1 = new DateTime($data_inizio);
//$d2 = new DateTime($data_fine);
$d1 =  strtotime($data_inizio);
$d2 =  strtotime($data_fine);

//$d1 = DateTime::createFromFormat('Y-m-d H:M', strtotime($data_inizio));
//$d2 = DateTime::createFromFormat('Y-m-d H:M', $data_fine);
echo $data_inizio;
echo "<br>";
echo $data_fine;
echo "<br>";
echo $d1;
echo "<br>";
echo $d2;
echo "<br>";
if ($d1 > $d2) {
	echo "Errore: la data di inizio allerta (".$data_inizio.") deve essere antecedente la fine dell'allerta stessa(".$data_fine.")";
	exit;
}


$query="INSERT INTO eventi.join_tipo_allerta (id_evento,id_tipo_allerta,data_ora_inizio_allerta,data_ora_fine_allerta,messaggio_rlg) VALUES(".$id.",".$_POST["tipo"].",'".$data_inizio."','".$data_fine."','".$bollettino."');"; 
echo $query;
//exit;
$result = pg_query($conn, $query);
echo "<br>";





//exit;



$query_log= "INSERT INTO varie.t_log (schema,operatore, operazione) VALUES ('users','".$_SESSION["Utente"] ."', 'Creazione allerta per evento n. ".$id."');";
$result = pg_query($conn, $query_log);



//$idfascicolo=str_replace('A','',$idfascicolo);
//$idfascicolo=str_replace('B','',$idfascicolo);
echo "<br>";
echo $query_log;

//exit;
header("location: ../dettagli_evento.php?id=".$cf);


?>