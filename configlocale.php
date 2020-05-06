<?php

/*
$hostmysql = "62.149.150.65";
$usermysql = "Sql120708";
$pwdmysql = "290392f5";
$dbmysql = "Sql120708_4";
$tabella_codici = "codici_auth";
$token = "fchiriaco_1965";
*/


$hostmysql = "localhost";
$usermysql = "root";
$pwdmysql = "Fgm172826#";
$dbmysql = "monmeet";
$tabella_codici = "codici_auth";
$token = "fchiriaco_1965";


/*
$hostmysql = "localhost";
$usermysql = "iisvicouser";
$pwdmysql = "dddkxj3dfhccc";
$dbmysql = "iisvicodb";
$tabella_codici = "codici_auth";
$token = "fchiriaco_1965";
*/


$con = new mysqli($hostmysql,$usermysql,$pwdmysql,$dbmysql);
if ($con -> connect_errno) {
  echo "Errore di connessione al DB " . $con -> connect_error;
  exit();
}



$pagetitle = "<strong>Monitoraggio GSUITE MEET" . (isset($_SESSION["istituto"]) ? "<br>" . $_SESSION["istituto"] . "</strong>" : "</strong>"); 


$intestazioni_desiderate = ["Data","Email organizzatore" ,"Durata","Nome partecipante","Partecipante esterno all'organizzazione","Codice riunione","Tipo di client"];
$tipodati = ["d","s","i","s","b","s","s"];
$campidb = ["data","email_organizzatore","durata","nome_partecipante","esterno","codice_riunione","client"];

$separatore = ";";



?>