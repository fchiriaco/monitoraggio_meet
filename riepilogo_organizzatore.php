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


if(!isset($_POST["email_organizzatore"]) || empty(trim($_POST["email_organizzatore"])))
	$datiok = false;


if(!isset($_POST["dinizio"]) || empty(trim($_POST["dinizio"])))
	$datiok = false;

if(!isset($_POST["dfine"]) || empty(trim($_POST["dfine"])))
	$datiok = false;



if(!$datiok)
{
	
	echo '<h2 class="alert alert-danger text-center">Errore! tutti i campi sono obbligatori...</h2>';
	exit;
}	

$dstart = filter_var($_POST["dinizio"],FILTER_SANITIZE_STRING);
$dend = filter_var($_POST["dfine"],FILTER_SANITIZE_STRING);


$email_organizzatore = filter_var($_POST["email_organizzatore"],FILTER_SANITIZE_STRING);
$dinizio = dataperdb2(filter_var($_POST["dinizio"],FILTER_SANITIZE_STRING)) . " 00:00:00";
$dfine = dataperdb2(filter_var($_POST["dfine"],FILTER_SANITIZE_STRING)) . " 23:59:59";


$sql = "select data,codice_riunione,count(*) as numpersone,max(durata)/60 as durata_riunione  from {$tabella} where email_organizzatore = '{$email_organizzatore}' and (data between '{$dinizio}' and '{$dfine}')  group by codice_riunione order by data";


$rs = $con->query($sql);

if(mysqli_num_rows($rs) <= 0)
{
	echo '<h2 class="alert alert-danger text-center">Nessun record trovato...</h2>';
	exit;
	
}

$valret = '<h2 class="alert alert-info text-center">Riepilogo dati video conferenze per organizzatore<br><span style="color:red">' . $email_organizzatore . '</span><br><small> dal '  . $dstart . ' al ' . $dend . '</small></h2>';

$valret .=  '<table class="table table-responsive table-striped">';
//$valret .=  '<thead><tr class="success"><th>Data video conferenza</th><th>Codice</th><th>Numero partecipanti</th><th>Durata in minuti</th></tr></thead><tbody>';
$valret .=  '<thead><tr class="success"><th>Data video conferenza</th><th>Codice</th><th>Durata in minuti</th><th>&nbsp;</th></tr></thead><tbody>';

while($r = $rs->fetch_assoc())
{
	//$valret .= '<tr><td>' . datadadb($r["data"]) . "</td><td>" . $r["codice_riunione"] . "</td><td>" . $r["numpersone"] . "</td><td>" . (round($r["durata_riunione"]) <= 0 ? 'Meno di un minuto': round($r["durata_riunione"])) . "</td></tr>";
	$valret .= '<tr><td>' . datadadb($r["data"]) . "</td><td>" . $r["codice_riunione"] . "</td><td>" . (round($r["durata_riunione"]) <= 0 ? 'Meno di un minuto': round($r["durata_riunione"])) . "</td>" .  "<td><a target=\"_blank\" class=\"btn btn-primary\" href=\"presenze.php?codice_riunione={$r["codice_riunione"]}&datariunione=" . datadadb($r["data"]) . "\">Vedi dettagli</a>"  . "</td></tr>";
	
	
	
	
}

$valred .= '</tbody></table>';
echo $valret;
exit;




	


?>