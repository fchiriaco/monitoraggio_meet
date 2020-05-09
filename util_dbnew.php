<?php
/*
  connessione è una funzione che permette di effettuare la connessione ad un database di mysql
  esempio di utilizzo:
  $cn = connessione("localhost","root","pluto","clienti");
*/
function connessione($host,$utente,$password,$database)
{
	$cn = @new mysqli($host,$utente,$password,$database);
	if (mysqli_connect_errno())
	{
		echo "Errore durante la connessione al database";
		exit;
	}
 	return $cn;
}

/*
  esegui_query è una funzione che permette di eseguire una query
  esempio di utilizzo:
  $recordset = esegui_query($con,"select * from clienti","");
  
*/


function esegui_query($cn,$qry)
 {
    
	$rows = mysqli_query($cn,$qry);
	return $rows;
 }	


/*
  getrecord è una funzione che restituisce un array associativo contenente il record corrente
  esempio di utilizzo:
  $reccur = getrecord($risultato_query);
  echo $reccur[nomecampo];
  
*/
function getrecord($risultato_query)
 {

   if($risultato_query !== false)
   	$riga = $risultato_query->fetch_assoc();
   else
	$riga = false;
   return $riga;
 }
 
/*
  getnomecampo è una funzione che restituisce il nome del campo di una certa query eseguita
  esempio di utilizzo:
  $nome = getnomecampo($risultato_query,$indice);
  echo $nome;
*/
function getnomecampo($risultato_query,$indice_campo)
 {
	$ar = $risultato_query->fetch_fields();
	return $ar[$indice_campo]->name;
 }


/*
  numrec è una funzione che restituisce il numero di record restituiti da una query
  esempio di utilizzo:
  $num = numrec($risultato_query);
  echo $num;
*/

 function numrec($risultato_query)
 {
   if ($risultato_query)
	 return $risultato_query->num_rows;
   else
   	 return 0;
 }

/*
  gorecord è una funzione che sposta il puntatore del record in posizione $indice
  esempio di utilizzo:
  $num = gorecord($risultato_query,0);
  echo $num;
si sposta al primo record
*/

function gorecord($recset,$indice)
 {
	$recset->data_seek($indice);
 }

/*
  getnumcampi è una funzione che restituisce il numero di campi restituiti da una query
  esempio di utilizzo:
  parametri
  $risultato_query: risultato di una query
  $num = getnumcampi($risultato_query);
  echo $num;
*/

function getnumcampi($con)
 {
   return $con->field_count;
  }


/* 
  funzione per autenticare gli utenti
  Ha bisogno di una sessione aperta
  parametri: 
  $host: computer con mysql
  $username: nomeutente su mysql
  $password: password su mysql
  $dbaut: database per autenticazione
  $tabaut: tabella autenticazione
  $nomecampouser: nome del campo username nella tabella di autenticazione
  $nomecampopassword:nome del campo password nella tabella di autenticazione
  
  esempio:
   include "util_db.php";
   echo "<div id=lay1>";
   if (autentica_ut("localhost","root","ga2899","ipssmontagna","utenti")== true)
    echo "OK";
   echo "</div>";

 */

function autentica_ut($host,$username,$password,$dbaut,$tabaut,$nomecampouser="username",$nomecampopassword="password")
{
 
 if (isset($_POST["pwd"]) && isset($_POST["uname"]) && ($_POST["uname"] != "") && ($_POST["pwd"] != "")) 
   {
      $c = connessione($host,$username,$password,$dbaut);
      $uname = $c->real_escape_string($_POST["uname"]);
      $pwd = $c->real_escape_string($_POST["pwd"]);
      $qrytxt = "select * from $tabaut where $nomecampouser ='" . $uname ."' and $nomecampopassword =password('" . $pwd . "')";
 	$qry = esegui_query($c,$qrytxt);
 	if (numrec($qry) <= 0)
    	{
      		echo "<p align=center><b>Utente non autorizzato</b><br /><br /><a href='javascript:history.back()'>Torna Indietro</a>";
      		return false;
	}
	$rec = getrecord($qry);
	$_SESSION["aut"] = 1;
	$_SESSION["idut"] = $rec["id"];
   	return true;
   }
 elseif($_SESSION["aut"] == 1)
	return true;

 else 
 {
 ?>
  <form id="aut" method="post" action=<?php echo "\"" . $_SERVER["PHP_SELF"] . "\""; ?>>
  <table class="mytable3">
  <tr><td colspan="2" class="centrato"><b>Autenticazione utente</b></td></tr>
  <tr>
  <td style="text-align:right;">Utente:</td><td><input type="text" name="uname" /></td>
  </tr>
  <tr>
  <td style="text-align:right;">Password:</td> <td><input type="password" name="pwd" /></td>
  </tr>
  <tr>
  <td colspan="2" class="centrato"><input type="submit" name="invia" value="ACCEDI" /></td>
  </tr>
  </table>
  </form>
  
 <?php
 }
} 




/* 
  funzione per autenticare gli utenti
  Ha bisogno di una sessione aperta
  parametri: 
  $tabaut: tabella autenticazione
  $nomecampouser: nome del campo username nella tabella di autenticazione
  $nomecampopassword:nome del campo password nella tabella di autenticazione
  $nomecampoid: nme del campo chiave della tabella utenti utenti
  
 
 */

function autentica_ut2($tabaut,$nomecampouser="username",$nomecampopassword="password",$nomecampoid = "")
{
 
 if (isset($_POST["pwd"]) && isset($_POST["uname"]) && ($_POST["uname"] != "") && ($_POST["pwd"] != ""))  
   {
       $c = connessione($host,$username,$password,$dbaut);
       $uname = $c->real_escape_string($_POST["uname"]);
       $pwd = $c->real_escape_string($_POST["pwd"]);
  
        $qrytxt = "select * from $tabaut where $nomecampouser ='" . $uname ."' and $nomecampopassword =password('" . $pwd . "')";
        $qry = esegui_query($c,$qrytxt);
 	if (numrec($qry) <> 1)
    	{
      		echo "<p style=\"text-align:center;fontweight:bold;\">Utente non autorizzato<br /><br /><a href=\"javascript:history.back()\">Torna Indietro</a>";
      		return false;
	}
	$rec = getrecord($qry);
	$_SESSION["aut"] = 1;
	if($nomecampoid == "")
		$_SESSION["idut"] = $rec["id"];
	else 
		$_SESSION["idut"] = $rec[$nomecampoid];
   	return true;
   }
elseif($_SESSION["aut"] == 1)
	return true;
else 
 {
 ?>
  <form id="aut" method="post" action=<?php echo "\"" . $_SERVER["PHP_SELF"] . "\""; ?>>
  <table class="mytable31">
  <tr><td colspan="2" class="centrato"><b>Autenticazione utente</b></td></tr>
  <tr>
  <td style="text-align:right;">Utente:</td><td><input type="text" name="uname" /></td>
  </tr>
  <tr>
  <td style="text-align:right;">Password:</td> <td><input type="password" name="pwd" /></td>
  </tr>
  <tr>
  <td colspan="2" class="centrato"><input type="submit" name="invia" value="ACCEDI" /></td>
  </tr>
  </table>
  </form>
  
<?php
 }
} 


?>
