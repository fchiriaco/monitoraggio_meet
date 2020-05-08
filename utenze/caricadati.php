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



function intestazione_tabella($campi_tabella)
{
	$intesta = '<tr>'; 
	foreach($campi_tabella as $k => $v)
		$intesta .= '<th>' . $k . '</th>';
	$intesta .= '<th>&nbsp;</th><th>&nbsp;</th>';
	$intesta .= '</tr>';
	return $intesta;
}

function dati_tabella($campi_tabella,$recordset,$campochiave)
{
	$intesta = "";
	while($r = getrecord($recordset))
	{
		$intesta .= '<tr>'; 
			foreach($campi_tabella as $k => $v)
				$intesta .= '<td>' . $r[$v] . '</td>';
		$intesta .= '<th><a href="' . $r[$campochiave] .'" class="btn btn-primary edit"><span class="glyphicon glyphicon-edit"></span></a></th><th><a href="' . $r[$campochiave] .'" class="btn btn-danger delete"><span class="glyphicon glyphicon-trash"></span></a></th>';
		$intesta .= '</tr>';
	}
	return $intesta;
}



function prepara_nav($numerorighedb,$start,$maxrighe)
{
	$navstr = '<p class="text-center" style="margin-top:10px;">';
	if(($start  > 0) && ($start - $maxrighe) >= 0)
		$navstr .= '<button class="btn btn-primary" id="left" posleft="' . ($start - $maxrighe) . '"><span class="glyphicon glyphicon-chevron-left"></span></button>';
	if(($start  < $numerorighedb) && (($start + $maxrighe) < $numerorighedb))
		$navstr .= ' <button class="btn btn-primary" id="right" posright="' . ($start + $maxrighe) . '"><span class="glyphicon glyphicon-chevron-right"></span></button>';
	$navstr .= '</p>';
	return $navstr;
}

$arricerca = array();
$partewhere = "";
$passati_valori_ricerca = false;
$righe = intval($_POST["righe"]);
if(!is_numeric($righe))
{
	$righe = $max_num_rec_vis;
}
$startrec = intval($_POST["start"]);
if(!is_numeric($startrec))
{
	$startrec = 0;
}

$cricerca =  trim($_POST["campiricerca"]) . "";
if(!empty($cricerca))
{
	$arricerca = explode("|",$_POST["campiricerca"]);
	$passati_valori_ricerca = true;
}
$i = 0;
$j = 0;
if($passati_valori_ricerca)
{
	foreach($campi_ricerca as $v)
	{
		if($passati_valori_ricerca && trim($arricerca[$i]) != "")
			switch($campi_ricerca_tipo[$v])
			{
				case "s":
					if($j == 0)
					{
						$j++;
						$partewhere .= $v . " like '" . $arricerca[$i] . "%' ";
					}
					else
					{
						$partewhere .= "and " . $v . " like '" . $arricerca[$i] . "%' ";
					}
					break;
					case "n":
					if($i == 0)
					{
						$j++;
						$partewhere .= $v . " = " . $arricerca[$i] . " ";
					}
					else
					{
						$partewhere .= "and " . $v . " = " . $arricerca[$i] . " ";
					}
					break;
					case "d":
					if($i == 0)
					{
						$j++;
						$partewhere .= $v . " = '" . dataperdb2($arricerca[$i]) . "' ";
					}
					else
					{
						$partewhere .= "and " . $v . " = '" . dataperdb2($arricerca[$i]) . "' ";
					}
					break;
			}
	
		$i++;
	}
}
if(trim($partewhere) == "")
	$partewhere = "1";

$query = "select count(*) as nr from {$tabella} where " . $partewhere . " order by " . $orderby;
$rs = esegui_query($con,$query);
$r = getrecord($rs);
$numerorighe = $r["nr"];


$query = "select * from {$tabella} where " . $partewhere . " order by " . $orderby . " limit " . $startrec . "," . $righe;

$rs = esegui_query($con,$query);

if(numrec($rs) <= 0)
{
	$stringa .= '<h1 class="alert alert-danger text-center">Nessun record presente  in archivio</h1>';
	
}
$stringa .= '<div class="tabella"><table class="table table-responsive">';
$stringa .= '<thead class="colorehead">';
$stringa .= intestazione_tabella($campi_tabella_righe);
$stringa .= '</thead>';
$stringa .= '<tbody>';
$stringa .= dati_tabella($campi_tabella_righe,$rs,$campo_chiave);
$stringa .= '</tbody>';
$stringa .= '</table></div>';

if($numerorighe > 0)
	$stringa .= prepara_nav($numerorighe,$startrec,$righe);
$stringa .= '<p class="text-center"><button id="addrec" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> AGGIUNGI NUOVO</button></p>';
echo $stringa;
?>