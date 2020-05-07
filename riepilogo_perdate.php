<?php 
session_start();
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	header("location: index.php");
$tabella = $_SESSION["tabella"];
if($_SESSION["user"])
	exit;
?>
<?php
include('configlocale.php');
include("util_func2.php");

$datiok = true;




if(!isset($_POST["diniziod"]) || empty(trim($_POST["diniziod"])))
	$datiok = false;

if(!isset($_POST["dfined"]) || empty(trim($_POST["dfined"])))
	$datiok = false;



if(!$datiok)
{
	
	echo '<h2 class="alert alert-danger text-center">Errore! tutti i campi sono obbligatori...</h2>';
	exit;
}	

$dstart = filter_var($_POST["diniziod"],FILTER_SANITIZE_STRING);
$dend = filter_var($_POST["dfined"],FILTER_SANITIZE_STRING);


$dinizio = dataperdb2(filter_var($_POST["diniziod"],FILTER_SANITIZE_STRING)) . " 00:00:00";
$dfine = dataperdb2(filter_var($_POST["dfined"],FILTER_SANITIZE_STRING)) . " 23:59:59";




$sql = "select distinct substr(data,1,10) as dat,codice_riunione,email_organizzatore from {$tabella} where (data between '{$dinizio}' and '{$dfine}') order by data,email_organizzatore";




$rs = $con->query($sql);

if(mysqli_num_rows($rs) <= 0)
{
	echo '<h2 class="alert alert-danger text-center">Nessun record trovato...</h2>';
	exit;
	
}

$valret = '<h2 class="alert alert-info text-center">Riepilogo dati video conferenze<br><small> <span style="color:red">dal '  . $dstart . ' al ' . $dend . '</span></small></h2>';

$valret .=  '<table class="table table-responsive table-striped">';
$valret .=  '<thead><tr class="success"><th>Data video conferenza</th><th>Codice</th><th>Email organizzatore</th><th>&nbsp;</tr></thead><tbody>';

while($r = $rs->fetch_assoc())
{
	$valret .= '<tr><td>' . datadadb($r["dat"]) . "</td><td>" . $r["codice_riunione"] . "</td><td>" .  $r["email_organizzatore"] . "</td>"  . "<td><a target=\"_blank\" class=\"btn btn-primary\" href=\"presenze.php?codice_riunione={$r["codice_riunione"]}&datariunione=" . datadadb($r["dat"]) . "\">Vedi dettagli</a>"  . "</td></tr>";
	
}

$valred .= '</tbody></table>';
echo $valret;
exit;


?>