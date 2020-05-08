<?php
session_start();
include("configlocale.php");
include("{$dirsito}config.php");
include("{$dirsito}libreria/util_func2.php");
if(!isset($_SESSION["login"]) || $_SESSION["login"] != "AUT_1_2015#" || $_SESSION["uname"] != "admin")
{
	session_destroy();
	header("location: {$dirsitoscript}login.php");
	exit;
}
include($dirsito . "libreria/util_dbnew.php");
$con = connessione(HOST,USER,PWD,DBNAME);


/* controllo campi obbligatori non vuoti */
foreach($campi_obbligatori_ins_upd as $v)
{
	if(!isset($_POST["upd-" . $v]) || (trim($_POST["upd-" . $v]) == ""))
	{
		echo "Errore: campo " . $v . " obbligatorio!!!";
		exit;
	}
	
}

$campochiave = mysqli_real_escape_string($con,$_POST["campochiave"]);


if(isset($crea_account) && $crea_account == 1)
{
		
	$qry = "select {$chiave_esterna_utente} from  {$tabella} where  {$campo_chiave} = ";
	$qry .=  (($tipo_chiave == "s") ? "'" . $campochiave . "'" : $campochiave);  
	$rsuser = esegui_query($con,$qry);
	$ruser = getrecord($rsuser);
	$utcorrente = $ruser[$chiave_esterna_utente];
	
	
	
	$stringa_upd_utente = "update {$tabella_utenti} set ";
	
	$j = 0;
	
	function check_user($con,$tabella_ut,$nomecampouser,$valorecampouser,$chiave_utente_nome,$chiave_utente_valore,$tipochiaveutente)
	{
		$sql = "select * from {$tabella_ut} where {$nomecampouser} = '{$valorecampouser}' and {$chiave_utente_nome} != ";
		$sql .= (($tipochiaveutente == "s") ? "'" . $chiave_utente_valore . "'" : $chiave_utente_valore);
		$rs = esegui_query($con,$sql);
		if(numrec($rs) > 0)
			return false;
		else
			return true;
		
	}
	
	
	
	foreach($campi_account as $v)
	{
		
		
		$campo = mysqli_real_escape_string($con,$_POST["upd-" . $v]);
		
		if(trim($campo) == "" && $tipo_campi_account[$v] != "p" )
		{
			echo "Errore campo " . $v . " obbligatorio!!!";
			exit;
		}
		if($tipo_campi_account[$v] == "s")
		{
			
			$stringa_upd_utente .= ($j == 0) ? $v . " = " . "'" . $campo . "'" : "," . $v . " = " ."'" . $campo . "'";
		}
		elseif($tipo_campi_account[$v] == "d")
		{
			$stringa_upd_utente .= ($j == 0) ? $v . " = " . "'" . dataperdb2($campo) . "'" : "," . $v . " = " . "'" . dataperdb2($campo) . "'";
		}
		elseif($tipo_campi_account[$v] == "p")
		{
			if(trim($campo) != "")
				$stringa_upd_utente .= ($j == 0) ? $v . " = " . "password('" . $campo . "')" : "," . $v . " = " . "password('" . $campo . "')";
		}
		else
		{
			$stringa_upd_utente .= ($j == 0) ? $v . " = " . $campo : "," . $v . " = " . $campo;
		}
		
		$j++;	
	}
	$stringa_upd_utente .= " where  {$campo_chiave_utenti} = "  . (($tipo_chiave_utenti == "s") ? "'" . $utcorrente . "'" : $utcorrente);
	$valorecampouser =  mysqli_real_escape_string($con,$_POST["upd-" . $campo_nome_utente]);
	
	if(check_user($con,$tabella_utenti,$campo_nome_utente,$valorecampouser,$campo_chiave_utenti,$utcorrente,$tipo_chiave_utenti) === false)
	{
		echo "Errore nome utente occupato";
		exit;
	}
	$ret = esegui_query($con,$stringa_upd_utente);
	if($ret === false)
	{
		echo "Errore!!";
		exit;
	}
	
	
	
}







$sqlupdate = "update {$tabella} set ";

$i = 0;
foreach($campi_tabella as $v)
{
		
	$campo = mysqli_real_escape_string($con,$_POST["upd-" . $v]);
	if($tipo_campi_tabella[$v] == "s")
		$sqlupdate  .= ($i == 0) ? $v . "= '" . $campo . "'" : "," . $v . "= '" . $campo . "'";
	elseif($tipo_campi_tabella[$v] == "d")
		$sqlupdate  .= ($i == 0) ? $v . "= '" . dataperdb2($campo) . "'" : "," . $v . "= '" . dataperdb2($campo) . "'";
	elseif($tipo_campi_tabella[$v] == "p")
		$sqlupdate  .= ($i == 0) ? $v . "= MD5('" . $campo . "')" : "," . $v . "= MD5('" . $campo . "')";
	else
		$sqlupdate  .= ($i == 0) ? $v . "= " . $campo : "," . $v . "= " . $campo ;
	$i++;
}

if($tipo_chiave == "s")
	$sqlupdate .= " where {$campo_chiave} = '{$campochiave}'";
else
	$sqlupdate .= " where {$campo_chiave} = {$campochiave}";

$ret = esegui_query($con,$sqlupdate);
if($ret === false)
	echo  "Errore!!";
else
	echo "Record aggiornato con successo!!";

?>