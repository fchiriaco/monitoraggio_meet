<?php 
session_start();
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	header("location: index.php");
$tabella = $_SESSION["tabella"];
?>
<?php
include('configlocale.php');
include("util_func2.php");

$datiok = true;


if(!isset($_POST["codice_riunione2"]) || empty(trim($_POST["codice_riunione2"])))
	$datiok = false;


if(!isset($_POST["datariunione2"]) || empty(trim($_POST["datariunione2"])))
	$datiok = false;




if(!$datiok)
{
	
	echo '<h2 class="alert alert-danger text-center">Errore! tutti i campi sono obbligatori...</h2>';
	exit;
}	

$codice_riunione = str_replace("-","",filter_var($_POST["codice_riunione2"],FILTER_SANITIZE_STRING));
$data_riunione = filter_var($_POST["datariunione2"],FILTER_SANITIZE_STRING);
$dinizio = dataperdb2($data_riunione) . " 00:00:00";
$dfine = dataperdb2($data_riunione). " 23:59:59";




$sql = "select data,email_organizzatore,nome_partecipante,sum(durata)/60 as durata_riunione from {$tabella} where codice_riunione = '{$codice_riunione}' and (data between '{$dinizio}' and '{$dfine}')  group by nome_partecipante order by nome_partecipante";




$rs = $con->query($sql);

if(mysqli_num_rows($rs) <= 0)
{
	echo '<h2 class="alert alert-danger text-center">Nessun record trovato...</h2>';
	exit;
	
}

$organizzatore = "";
$duratari = 0;
$totale_partecipanti = 0;

$valret = '<h2 class="alert alert-info text-center">Riepilogo dati presenze video conferenze per codice e data <br><small>Codice: <span style="color:red">' . $codice_riunione . '</span> Data: <span style="color:red">' . $data_riunione .  '</span></small></h2>';

$valret .=  '<table class="table table-responsive table-striped">';
$valret .=  '<thead><tr class="success"><th>Data</th><th>Nome partecipante</th><th>Durata in minuti</th></tr></thead><tbody>';

while($r = $rs->fetch_assoc())
{
	if($organizzatore == "")
		$organizzatore = $r["email_organizzatore"];
	if($duratari <= round($r["durata_riunione"]))
		$duratari =  round($r["durata_riunione"]);
	
	$valret .= '<tr><td>' . $data_riunione . "</td><td>" . $r["nome_partecipante"] . "</td><td>" . (round($r["durata_riunione"]) <= 0 ? 'Meno di un minuto': round($r["durata_riunione"])) . "</td></tr>";
	$totale_partecipanti++;
	
}

$valred .= '</tbody></table>';

$valret .= '<h3>Organizzatore: ' . $organizzatore . '</h3>';
$valret .= '<h3>Durata riunione in minuti: ' . $duratari . '</h3>';
$valret .= '<h3>Numero partecipanti: ' . $totale_partecipanti . '</h3>';

echo $valret;
exit;




	


?>