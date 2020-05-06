<?php
/* str_array è una funzione che trasforma una stringa in un array 
   nella stringa gli elementi sono separati da $separatore
*/
function str_array($separatore,$stringa)
 {
 	return explode($separatore,$stringa);
 }
 
/* array_str è una funzione che trasforma una stringa in un array unendo gli elementi con $separatore */


function array_str($separatore,$vettore)
 {
 	return implode($separatore,$vettore);
 }

 /*  stringa_replace restituisce una stringa con $valore_in_stringa sostituito da $sostituto */
 
function stringa_replace($valore_in_stringa,$sostituto,$stringa)
 {
 	return str_replace($valore_in_stringa,$sostituto,$stringa);
	/* return ereg_replace($valore_in_stringa,$sostituto,$stringa);*/
 }
 
/* upload_file copia un file passato da un campo file di un form nella $dir specificata (sul server) */

function upload_file($dir,$nomecampo_file="userfile")
 {
 	$fname = basename($_FILES[$nomecampo_file]['name']);
	$userfile =  $_FILES[$nomecampo_file]['tmp_name'];
	$destfile = (strrpos($dir,"/") == (strlen($dir)-1)) ? ($dir . $fname):($dir . "/" . $fname);
	copy($userfile,"$destfile");
	return $destfile;
 }


function upload_file2($dir,$destinazione = "",$nomecampo_file="userfile")
 {
 	$fname = basename($_FILES[$nomecampo_file]['name']);
	$userfile =  $_FILES[$nomecampo_file]['tmp_name'];
	if($destinazione == "")
		$destfile = (strrpos($dir,"/") == (strlen($dir)-1)) ? ($dir . $fname):($dir . "/" . $fname);
	else
		$destfile = (strrpos($dir,"/") == (strlen($dir)-1)) ? ($dir . $destinazione):($dir . "/" . $destinazione);
	copy($userfile,"$destfile");
	return $destfile;
 }



function esiste_chiave_in_array($chiave,$array)
 {
    if (array_key_exists($chiave,$array))
      return true;
    else
      return false;
 }


/* 
function esiste_chiave_in_array($chiave,$array)
 {
   if(($array[$chiave] != "") && ($array[$chiave] != NULL))
	return true;
   else
	return false;
 }	

*/

function contafile($direttorio="./")
 {
	$d = opendir($direttorio);
	$nf = 0;
	while($f = readdir($d))
	 if (($f != ".") && ($f != ".."))
		$nf++;
	return $nf;
 }


function legginomifile($direttorio="./")
 {
	$d = opendir($direttorio);
	$nf= "";
	while($f = readdir($d))
	 if (($f != ".") && ($f != ".."))
		$nf .= $f . "|";
	return substr($nf,0,strlen($nf) -1);
 }


function subdir($direttorio="./")
 {
	chdir($direttorio);
	$d = opendir($direttorio);
	$direttori = "";
	while($f = readdir($d))
	 if (($f != ".") && ($f != ".."))
		if (is_dir($f))
		  $direttori .= $f . ",";
        $direttori = substr($direttori,1,strlen($direttori)-1);
	return $direttori;
 }



function mymail($a_chi,$da_chi,$oggetto,$corpo,$allegato = "")
{
  $mailboundary = "";
 $mailbody = "";
  if ($allegato != "")
	{
		$mailboundary = md5(uniqid(time()));
		$mailheader = "Mime-Version: 1.0\r\n";
		$mailheader .= "Content-type: multipart/mixed;boundary=\"$mailboundary\"\r\n";
		$mailheader .= "From: $da_chi";
		$mailheader .= "\r\n\r\n";
		$f = fopen($allegato,"r");
		$file = fread($f,filesize($allegato));
		$file = chunk_split(base64_encode($file));

		$mailbody = "--$mailboundary\r\n";
		$mailbody .= "Content-type: text/html\r\n";
		$mailbody .= "Content-transfer-encoding: 8bit\r\n\r\n";
		$mailbody .= "$corpo\r\n";
		$mailbody .= "--$mailboundary\r\n";
		$nomefile = basename($allegato);
		$mailbody .= "Content-type: application/octet-stream;name=$nomefile\r\n";
		$mailbody .= "Content-transfer-encoding: base64\r\n\r\n";
		$mailbody .= $file . "\r\n\r\n";
		$mailbody .= "--$mailboundary--";
		
	}
  else
	{
		
		$mailheader = "MIME-Version: 1.0\r\n";
		$mailheader .= "From: {$da_chi}\r\n";
		/* $mailheader .= "Content-type: text/html\r\n"; */
		$mailheader .= "Content-transfer-encoding: 8bit";
		$mailheader .= "\r\n\r\n";
		
		
		
		$mailbody .= "$corpo\r\n";
		
	}
	mail($a_chi,$oggetto,$mailbody,$mailheader);
	
}


/* restituisce un array associativo con data e ora da un campo timestamp */
function data_ora($tabella,$campotimestamp,$campo_chiave,$valore_chiave,$tipo_campo_chiave="numerico")
{
	if ($tipo_campo_chiave == "numerico")
		$sql = "select $campotimestamp from $tabella where $campo_chiave = $valore_chiave";
	else
		$sql = "select $campotimestamp from $tabella where $campo_chiave = '$valore_chiave'";
	$rec = esegui_query($sql);
	$riga = getrecord($rec);
	$data_ora1 = $riga[$campotimestamp] . "";
	$dataora["data"] = $data_ora1{6} . $data_ora1{7} . "/" . $data_ora1{4} . $data_ora1{5} . "/" . $data_ora1{0}.$data_ora1{1}.$data_ora1{2} . $data_ora1{3};
	$dataora["ora"] = $data_ora1{8} . $data_ora1{9} . ":" . $data_ora1{10} . $data_ora1{11};
	return $dataora;
}


/* restituisce un array associativo con data e ora da un timestamp */

function data_ora_timestamp($campotimestamp)
{
	
	$data_ora1 = $campotimestamp . "";
	$dataora["data"] = $data_ora1{6} . $data_ora1{7} . "/" . $data_ora1{4} . $data_ora1{5} . "/" . $data_ora1{0}.$data_ora1{1}.$data_ora1{2} . $data_ora1{3};
	$dataora["ora"] = $data_ora1{8} . $data_ora1{9} . ":" . $data_ora1{10} . $data_ora1{11};
	return $dataora;
}

function dataoggi()
{
  $data = getdate();
  $dataret = ((strlen($data['mday']) < 2) ? ("0" . $data['mday']):$data['mday'])  . "/" . ((strlen($data['mon']) < 2) ? ("0" . $data['mon']):$data['mon']) . "/" . $data['year'];
  return $dataret;
}


function dataperdb($stringa)
{
	$stringa1 = stringa_replace("-","/",$stringa);
	$stringa = $stringa1;
	$elementi = str_array("/",$stringa);
	if(count($elementi) < 3)
		$stringa = dataoggi();
	$elementi = str_array("/",$stringa);
	if (strlen($elementi[0]) < 2)
		$elementi[0] = "0" . $elementi[0];
	if (strlen($elementi[1]) < 2)
		$elementi[1] = "0" . $elementi[1];
	if (strlen($elementi[2]) < 4)
		{
			$stringa = dataoggi();	
			$elementi[2] = substr($stringa,6,4);	
		}
	$data = getdate();
	$datadb = $elementi[2] . "-" . $elementi[1] . "-" . $elementi[0] . " " . $data['hours'] .":" .  $data['minutes'] . ":" . $data['seconds'];
	return $datadb;
}



function dataperdb2($stringa)
{
	$stringa1 = stringa_replace("-","/",$stringa);
	$stringa = $stringa1;
	$elementi = str_array("/",$stringa);
	if(count($elementi) < 3)
		$stringa = dataoggi();
	$elementi = str_array("/",$stringa);
	if (strlen($elementi[0]) < 2)
		$elementi[0] = "0" . $elementi[0];
	if (strlen($elementi[1]) < 2)
		$elementi[1] = "0" . $elementi[1];
	if (strlen($elementi[2]) < 4)
		{
			$stringa = dataoggi();	
			$elementi[2] = substr($stringa,6,4);	
		}
	
	$datadb = $elementi[2] . "-" . $elementi[1] . "-" . $elementi[0];
	return $datadb;
}





function datadadb($campo)
{
 	$campo = substr($campo,0,10) . "";
	$stringa1 = stringa_replace("-","/",$campo);
	$elementi = str_array("/",$stringa1);
	$datadb = $elementi[2] . "/" .  $elementi[1] . "/" . $elementi[0];		 
	return $datadb;
}

function da_datetime_ora($campo)
{
 	return substr($campo,10) . "";
	
}


function oradadb($campo)
{
  $campo = substr($campo,0,8) . "";	
  $elementi = str_array(":",$campo);
  $oradb = $elementi[0] . ":" . $elementi[1];
  return $oradb;
}

function oraperdb($campoora,$campominuti)
{
  if($campoora == "")
	$campoora = "00";
  if($campominuti == "")
	$campominuti = "00";

  $ora = ((strlen($campoora) == 2) ? $campoora : ("0" . $campoora));
  $minuti = ((strlen($campominuti) == 2) ? $campominuti : ("0" . $campominuti));
  $oraperdb = $ora . ":" . $minuti;
  return $oraperdb;
}


function giorno_da_data($data)
{
	if (strlen($data) != 10) 
		return 35;
	$giorno = $data{0} . $data{1};
	return $giorno;
}


function mese_da_data($data)
{
	if (strlen($data) != 10) 
		return 35;
	$mese = $data{3} . $data{4};
	return $mese;
}

function anno_da_data($data)
{
	if (strlen($data) != 10) 
		return 0000;
	$anno = $data{6} . $data{7} . $data{8} . $data{9};
	return $anno;
}

function miotestdata($data)
{
 	$giorno = giorno_da_data($data);
	$mese = mese_da_data($data);
	$anno =  anno_da_data($data);
	$testdata = checkdate($mese,$giorno,$anno);
	if (!$testdata)
		return false;
	else
		return true;
}



function timestamp_da_data($data)
{
	$giorno = giorno_da_data($data);
	$mese = mese_da_data($data);
	$anno =  anno_da_data($data);
	if (!checkdate($mese,$giorno,$anno))
		return false;
	$giorno = (int) $giorno;
	$mese = (int) $mese;
	$anno = (int) $anno;
	$tms = mktime(0,0,0,$mese,$giorno,$anno);
	return $tms;
}


/* la data deve essere in formato aaaa-mm-gg hh:mm:ss */
function timestamp_da_data2($data)
{
	$giorno = $data{8} . $data{9};
	$mese = $data{5} . $data{6};
	$anno =  $data{0} . $data{1} . $data{2} . $data{3};
	$ora = $data{11} . $data{12};
	$minuti = $data{14} . $data{15};
	$secondi = $data{17} . $data{18};
	if (!checkdate($mese,$giorno,$anno))
		return false;
	$giorno = (int) $giorno;
	$mese = (int) $mese;
	$anno = (int) $anno;
	$tms = mktime($ora,$minuti,$secondi,$mese,$giorno,$anno);
	return $tms;
}


function array_da_qry($qry,$nomecampo)
    {
	  $i = 0;
	  $ris = esegui_query($qry);
	  while($riga = getrecord($ris))
		{
			$arr[$i] = $riga[$nomecampo];
			$i++;
		}
	return $arr;
    }
    
function array_da_qrynew($con,$qry,$nomecampo)
    {
	  $i = 0;
	  $ris = esegui_query($con,$qry);
	  while($riga = getrecord($ris))
		{
			$arr[$i] = $riga[$nomecampo];
			$i++;
		}
	return $arr;
    }



function myalert($avviso,$urldest="")
	{
		echo "<script language=\"javascript\" type=\"text/javascript\">\n";
		if ($avviso != "")
			echo "alert('$avviso');\n";
		if($urldest != "")
			echo "document.location = \"$urldest\";\n";
		echo "</script>";
	}

function genera_casuale($minimo,$massimo)
{
  mt_srand((double) microtime() * 1000000);
  $numcasuale = mt_rand($minimo,$massimo);
  return $numcasuale;

}


function myconfirm($avviso,$urldest)
	{
		echo "<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "risp=confirm('$avviso');\n";
		echo "if (risp==true) {\n document.location = \"$urldest\";}\n";
		echo "</script>";
	}


function window_open($larghezza=200,$altezza=200,$top=2,$left=2,$pagina='',$titolo = '',$contenuto='&nbsp;',$tool='no',$scroll='no',$menu='no')
{
 echo "<script language=\"javascript\" type=\"text/javascript\">\n";
 echo "wnd = window.open('$pagina', '$titolo','toolbar=$tool,menubar=$menu,scrollbars=$scroll,top=$top,left=$left,height=$altezza,width=$larghezza');\n";
 if ($pagina == "")
 {
 	echo "wnd.document.writeln('<p align=center>');\n";
    echo "wnd.document.writeln('<input type=button value=Chiudi onclick=\"window.close();\">');\n";
	echo "wnd.document.writeln('<input type=button value=Stampa onclick=\"window.print();\">');\n";
	echo "wnd.document.writeln('<hr><h3 align=center>{$titolo}</h3>{$contenuto}');\n"; 
	echo "wnd.document.close();";
 }
 
 echo "</script>";
}

function checkmail($mail)
{
	return preg_match("/^.+@.+\.[a-zA-Z]{2,3}$/",$mail);
		
	
}



/*funzione che dato mese e anno genera array con indice giorno  e valore giorno settimana */
function genera_mese($mese,$anno)
{
	$giorniset = array("DO","LU","MA","ME","GI","VE","SA");
	$argiorni = array();
	for($i = 1;$i <= 31;$i++)
	{
		if(checkdate($mese,$i,$anno))
		{
			$tm = mktime(0,0,0,$mese,$i,$anno);
			$argiorni[$i] = $giorniset[date("w",$tm)];
		}
	}
	return $argiorni;
	
}

?>
