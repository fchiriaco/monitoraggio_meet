<?php 
session_start();
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	header("location: index.php");
$tabella = $_SESSION["tabella"];
if(!$_SESSION["admin"])
	exit;
?>
<?php
include('configlocale.php');

$datiok = true;

$mesi_it = array("gen","mag","giu","lug","ago","set","ott","dic");
$mesi_en = array("jan","may","jun","jul","aug","sept","oct","dec");



if (!is_uploaded_file($_FILES['file']['tmp_name']))
	$datiok = false;	

if(!$datiok)
{
	/*
	echo '<p style="text-align:center">';
	echo 'Dati insufficienti per procedere ';
	echo '<a href="index.php" title="back">TORNA INDIETRO</a>';
	echo '</p>';
	exit;
	*/
	echo '<h2 class="alert alert-danger text-center">Errore! Occorre specificare un file...</h2>';
	exit;
}	


	
chmod('uploads',0777);

move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);



$nomefile = 'uploads/' . $_FILES['file']['name'];





$filein = fopen($nomefile,"r");



$testata = fgets($filein);



$ar_posizioni_campi_intestazione = [];

$ar_intestazioni = explode($separatore,$testata);



$posizione_campo = 0;

foreach($ar_intestazioni as $v)
{
	
	$v = trim(str_replace(array("\n","\r"),"",$v));
	if(in_array($v,$intestazioni_desiderate))
		array_push($ar_posizioni_campi_intestazione,$posizione_campo);
	
	$posizione_campo++;
		
}




while(!feof($filein))
{
	
	$riga = fgets($filein);
	
	$riga = str_replace(array("\n","\r"),"",$riga);
	
	
	
	$row = explode($separatore,$riga);
	
	
	
	
	$sql = "insert into {$tabella}(";
	foreach($campidb as $c)
		$sql .= $c . ",";
	$sql = substr($sql,0,strlen($sql)-1) . ") values(";
	
	$indice_campo = 0;
	
	foreach($ar_posizioni_campi_intestazione as $indice)
	{
		
		
		$valorecampo = "";
		switch($tipodati[$indice_campo])
		{
			case "d":
				$valorecampo = "'" . date("Y-m-d H:i:s",strtotime(str_replace($mesi_it,$mesi_en,$row[$indice]))) . "'";
				break;
			case "i":
				$valorecampo = $row[$indice];
				break;
			case "s":
				$valorecampo = "'" . addslashes(utf8_encode($row[$indice])) . "'";
				break;
			case "b":
				$valorecampo = ($row[$indice] == "No" ? 0:1);
				break;
			
		}
		
		$sql .= $valorecampo . ",";
		$indice_campo++;
		
		
		
	}
	$sql = substr($sql,0,strlen($sql)-1) . ")"; 
	
	
	
	$res = $con->query($sql);
	
}

fclose($filein);
chmod('uploads',0755);
/*
echo '<p style="text-align:center">';
echo "Caricamento dati avvenuto con successo...<br><br>";
echo '<a href="index.php" title="home">TORNA INDIETRO</a>';
echo '</p>';

*/
echo '<h2 class="alert alert-success text-center">Dati caricati correttamente</h2>';
?>