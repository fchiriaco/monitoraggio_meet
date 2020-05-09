<?php
session_start();
if((isset($_SESSION["auth"]) && $_SESSION["auth"] === true) && (isset($_SESSION["codice_scuola"]) && !empty($_SESSION["codice_scuola"])))
{
	echo "1";
	exit;
}
include('configlocale.php');
if(md5($token) != $_POST["token"])
{
	echo 0;
	exit;
	
}	

if(!isset($_POST["codice_scuola"]) || empty(trim($_POST["codice_scuola"])))
{
	echo 0;
	exit;
	
}

$codice_scuola = filter_var($_POST["codice_scuola"],FILTER_SANITIZE_STRING);

$sql = "select * from {$tabella_codici} where (codice = '{$codice_scuola}' or codadmin = '{$codice_scuola}' or coduser = '{$codice_scuola}')";

$rs = $con->query($sql);



if(mysqli_num_rows($rs) <= 0)
{
	echo 0;
	exit;
	
}

$r = $rs->fetch_assoc();
$_SESSION["codice_scuola"] = $r["codice"];
$_SESSION["tabella"] = $r["nome_tabella"];
$_SESSION["admin"] = (strtoupper($r["codadmin"]) == strtoupper($codice_scuola)? 1:0);
$_SESSION["user"] = (strtoupper($r["coduser"]) == strtoupper($codice_scuola)? 1:0);
$_SESSION["auth"] = true;
$_SESSION["istituto"] = $r["nome_scuola"];
$_SESSION["email"] = $r["email"];
echo "1";
exit;


?>