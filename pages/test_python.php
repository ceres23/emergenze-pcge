<?php 
echo"INIZIO <br>";
$codvia='52600';
$ncivico='0093';
$colore='R';
$lettera='';
$descrizione='descrizione di prova chiamando script python da php';
if ($lettera==''){
	$command = escapeshellcmd('/usr/bin/python3 emergenze2manutenzioni.py -v '.$codvia.' 
	-n '.$ncivico.' -c '.$colore.' -d "'.$descrizione.'"');
} else {
	echo "TODO";
}
echo $command;
echo '<br>';
$output = shell_exec($command);
echo $output;
if ($output==200){
	echo "<br><br>OK segnalazione trasmessa correttamente al sistema di manutenzioni";
}
?>
