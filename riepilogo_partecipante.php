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


if(!isset($_POST["nome_partecipante"]) || empty(trim($_POST["nome_partecipante"])))
	$datiok = false;


if(!isset($_POST["diniziop"]) || empty(trim($_POST["diniziop"])))
	$datiok = false;

if(!isset($_POST["dfinep"]) || empty(trim($_POST["dfinep"])))
	$datiok = false;



if(!$datiok)
{
	
	echo '<h2 class="alert alert-danger text-center">Errore! tutti i campi sono obbligatori...</h2>';
	exit;
}	

$dstart = filter_var($_POST["diniziop"],FILTER_SANITIZE_STRING);
$dend = filter_var($_POST["dfinep"],FILTER_SANITIZE_STRING);


$nome_partecipante = $con->real_escape_string($_POST["nome_partecipante"]);
$dinizio = dataperdb2(filter_var($_POST["diniziop"],FILTER_SANITIZE_STRING)) . " 00:00:00";
$dfine = dataperdb2(filter_var($_POST["dfinep"],FILTER_SANITIZE_STRING)) . " 23:59:59";




$sql = "select data,codice_riunione,durata/60 as durata_riunione,client  from {$tabella} where nome_partecipante like '%{$nome_partecipante}%' and (data between '{$dinizio}' and '{$dfine}') order by data";




$rs = $con->query($sql);

if(mysqli_num_rows($rs) <= 0)
{
	echo '<h2 class="alert alert-danger text-center">Nessun record trovato...</h2>';
	exit;
	
}

$valret = '<h2 class="alert alert-info text-center">Riepilogo dati video conferenze per nominativo partecipante<br><span style="color:red">' . stripslashes($nome_partecipante) . '</span><br><small> dal '  . $dstart . ' al ' . $dend . '</small></h2>';

$valret .=  '<table class="table table-responsive table-striped">';
$valret .=  '<thead><tr class="success"><th>Data video conferenza</th><th>Codice</th><th>Durata in minuti</th><th>Tipologia Dispositivo usato</th><th>&nbsp;</tr></thead><tbody>';

while($r = $rs->fetch_assoc())
{
	$valret .= '<tr><td>' . datadadb($r["data"]) . "</td><td>" . $r["codice_riunione"] . "</td><td>" . (round($r["durata_riunione"]) <= 0 ? 'Meno di un minuto': round($r["durata_riunione"])) . "</td><td>" . $r["client"] . "</td>"  . "<td><a target=\"_blank\" class=\"btn btn-primary\" href=\"presenze.php?codice_riunione={$r["codice_riunione"]}&datariunione=" . datadadb($r["data"]) . "\">Vedi dettagli</a>"  . "</td></tr>";
	
}

$valred .= '</tbody></table>';
echo $valret;
exit;




	


?>