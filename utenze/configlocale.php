<?php
$dirsito = realpath(__DIR__ . "/../") . "/";
$dirsitoscript = "";
if($_SERVER['HTTPS'])
	$dirsitoscript = "https://";
else
	$dirsitoscript = "http://";
$dirsitoscript .= $_SERVER['SERVER_NAME'] . dirname($_SERVER["SCRIPT_NAME"]) . "/../"; 
$tabella = "codici_auth";

/* campi da visualizzare in fase di inserimento  - chiave/valore */

$campi_tabella = array("Codice per super admin" =>"codadmin",
					   "Codice per admin "=>"codice",
					   "Codice per normal user" => "coduser",
					   "Nome Scuola" => "nome_scuola",
					   "Email" => "email",
					   "Nome tabella dati" => "nome_tabella",
					   );


$tipo_campi_tabella = array("codadmin" => "s",
							"codice" => "s",
							"coduser" => "s",
							"nome_scuola" => "s",
							"email"=>"s",
							"nome_tabella" => "s",
							
							);			   

/* questa parte gestisce la creazione di un account utente associato ad ogni riga della tabella */
$crea_account = 0;
if($crea_account == 1)
{
	$campi_account = array("Nome Utente" => "username","Password" => "password");
	$tipo_campi_account = array("username" => "s","password" => "p"); /* p sta per password */
	$tabella_utenti = "utenti";
	$campo_nome_utente = "username";
	$tabella_aree_autorizzazione = "aree_aut";
	$aree_autorizzate = array("aziende");
	$livello = array(0);
	$campo_chiave_utenti = "id";
	$tipo_chiave_utenti = "n";
	/* chiave esterna su tabella principale collegata a campo chiave utenti */
	$chiave_esterna_utente = "idutente";
	$tipo_chiave_esterna = "n";
}

					   


/* campi da visualizzare sotto forma di tabella - chiave/valore */
   
$campi_tabella_righe = array("Nome Scuola" => "nome_scuola",
					   "Email" => "email",
					   "Nome tabella dati" => "nome_tabella",
					   
					   );

$campo_chiave = "id";
$tipo_chiave = "n"; /* s per stringhe - d per date - n per numeri */


$campi_ricerca = array("Nome Scuola" => "nome_scuola");
$campi_ricerca_tipo = array("nome_scuola" => "s"); /* s per stringhe - d per date - n per numeri */
$orderby = "nome_scuola";

$max_num_rec_vis = 10;

$campi_obbligatori_ins_upd = array("codadmin","codice","coduser","email","nome_scuola","nome_tabella",);
$campi_unici_tabella = array("codadmin","codice","coduser","email","nome_scuola","nome_tabella");
$tipo_campi_unici_tabella = array("s","s","s","s","s","s");

$titolopg = "Tabella scuole";

?>