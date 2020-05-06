<?php
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	exit;

include("util_func2.php");

$datiok = true;


if(!isset($_REQUEST["codice_riunione"]) || empty(trim($_REQUEST["codice_riunione"])))
	$datiok = false;


if(!isset($_REQUEST["datariunione"]) || empty(trim($_REQUEST["datariunione"])))
	$datiok = false;




if(!$datiok)
{
	
	echo '<h2 class="alert alert-danger text-center">Errore! tutti i campi sono obbligatori...</h2>';
	exit;
}	

$codice_riunione = str_replace("-","",filter_var($_REQUEST["codice_riunione"],FILTER_SANITIZE_STRING));
$data_riunione = filter_var($_REQUEST["datariunione"],FILTER_SANITIZE_STRING);
$dinizio = dataperdb2($data_riunione) . " 00:00:00";
$dfine = dataperdb2($data_riunione). " 23:59:59";


$sql0 = "select min(data) as datainizio from {$tabella} where codice_riunione = '{$codice_riunione}' and (data between '{$dinizio}' and '{$dfine}') and durata > 300";
$rs0 = $con->query($sql0);
if(mysqli_num_rows($rs0) <= 0)
{
	echo '<h2 class="alert alert-danger text-center">Nessun record trovato...</h2>';
	exit;
	
}
$r0 = $rs0->fetch_assoc();
$oracollegamento = da_datetime_ora($r0["datainizio"]);


$sql = "select data,email_organizzatore,nome_partecipante,esterno,sum(durata)/60 as durata_riunione,client from {$tabella} where codice_riunione = '{$codice_riunione}' and (data between '{$dinizio}' and '{$dfine}')  group by nome_partecipante order by nome_partecipante";



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
$valret .=  '<thead><tr class="success"><th>Data</th><th>Nome partecipante</th><th>Interno all\'organizzazione</th><th>Presenza partecipante in minuti</th><th>Tipologia dispositivo</th></tr></thead><tbody>';

while($r = $rs->fetch_assoc())
{
	if($organizzatore == "")
		$organizzatore = $r["email_organizzatore"];
	if($duratari <= round($r["durata_riunione"]))
		$duratari =  round($r["durata_riunione"]);
	
	
		
	$valret .= '<tr><td>' . $data_riunione . "</td><td>" . $r["nome_partecipante"] . "</td><td>" . ($r["esterno"] == 1 ? 'No':'Sì') . "</td><td>"  . (round($r["durata_riunione"]) <= 0 ? 'Meno di un minuto': round($r["durata_riunione"])) . "</td><td>" . $r["client"] . "</td></tr>";
	$totale_partecipanti++;
}

$valred .= '</tbody></table>';

$valret .= '<h3>Organizzatore: ' . $organizzatore . '</h3>';
$valret .= '<h3>Ora inizio: ' . $oracollegamento . '</h3>';
$valret .= '<h3>Durata riunione in minuti: ' . $duratari . '</h3>';
$valret .= '<h3>Numero partecipanti: ' . $totale_partecipanti . '</h3>';

echo $valret;

?>