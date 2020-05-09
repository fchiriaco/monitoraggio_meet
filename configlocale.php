<?php
include("configdb.php");

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