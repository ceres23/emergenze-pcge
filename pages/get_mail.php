<?php
session_start();


$cf= $_POST["cod"];
echo $cf;


include '/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php';

if(!empty($cf)) {
	$query = "select mail from users.v_utenti_esterni WHERE cf='".$cf."';";
    
    echo $query;
    //exit;
    $result = pg_query($conn, $query);

     while($r = pg_fetch_assoc($result)) { 
    ?>
			<option id="mail-input" value="<?php echo $r['mail'];?>" ><?php echo $r['mail'];?></option>
    <?php
    }

	
}
?>