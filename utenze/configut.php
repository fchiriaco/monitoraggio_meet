<?php
$tabella = "utenti";

/* campi da visualizzare in fase di inserimento  - chiave/valore */

$campi_tabella = array("Cognome" =>cognome,
					   "Nome"=>"nome",
					   "Email" => "email"
					   "Utente" => "username",
					   "Password" => "password",
					   );


$tipo_campi_tabella = array("Cognome" => "s",
							"nome" => "s",
							"email"=>"s",
							"username" => "s",
							"password" => "p",
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
   
$campi_tabella_righe = array("Cognome" => "cognome",
					   "Nome" => "nome",
					   "Email" => "email",
					   "username" => "username",
					   );

$campo_chiave = "id";
$tipo_chiave = "n"; /* s per stringhe - d per date - n per numeri */


$campi_ricerca = array("Cognome" => "cognome","Nome" => "nome");
$campi_ricerca_tipo = array("cognome" => "s","nome"=>"s"); /* s per stringhe - d per date - n per numeri */
$orderby = "cognome,nome";

$max_num_rec_vis = 10;

$campi_obbligatori_ins_upd = array("cognome","nome","email","username","password");
$campi_unici_tabella = array("username","email");
$tipo_campi_unici_tabella = array("s","s");

$titolopg = "Utenti";

?>