<?php 
session_start();
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	header("location: index.php");
$tabella = $_SESSION["tabella"];
if(!$_SESSION["admin"])
	exit;
include("configlocale.php");
include("util_func2.php");
$sql = "truncate table {$tabella}";
$con->query($sql);
myalert("Tabella dati svuotata","index2.php");
 
?>
