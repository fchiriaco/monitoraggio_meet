<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<title>Francesco Chiriaco</title>

  <!-- META -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- META -->
  
  <!-- CSS -->
  <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  
  
  <!-- CSS -->  

  <?php
    include("configlocale.php");
	include("util_func2.php");
	
$sql = "CREATE TABLE IF NOT EXISTS {$tabella_codici} (
  `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codice` varchar(255) NOT NULL,
  `codadmin` varchar(255) NOT NULL,
  `coduser` varchar(255) NOT NULL,
  `nome_tabella` varchar(255) NOT NULL,
  `nome_scuola` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codice` (`codice`),
  UNIQUE KEY `codadmin` (`codadmin`) USING BTREE,
  UNIQUE KEY `coduser` (`coduser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=1;";

$con->query($sql);
$sql = "select * from {$tabella_codici}";
$rs = $con->query($sql);
if(mysqli_num_rows($rs) >= 1)
{
	myalert("Applicazione già installata precedentemente...","index2.php");
	exit;
}
if(isset($_POST["submit"]))
{
	
	if(!isset($_POST["codice_s_admin"]) || trim($_POST["codice_s_admin"] . "") == ""  ||  !isset($_POST["codice_admin"]) || trim($_POST["codice_admin"] . "") == "" || !isset($_POST["codice_user"]) || trim($_POST["codice_user"] . "") == "" || !isset($_POST["nome_scuola"]) || trim($_POST["nome_scuola"] . "") == "" || !isset($_POST["email"]) || trim($_POST["email"] . "") == "" || !isset($_POST["tabella_dati"]) || trim($_POST["tabella_dati"] . "") == "")
	{
		myalert("Tutti i campi sono obbligatori...", "install.php");
	}
	
	$codice_s_admin = $con->real_escape_string($_POST["codice_s_admin"]) . "";
	$codice_admin = $con->real_escape_string($_POST["codice_admin"]) . "";
	$codice_user = $con->real_escape_string($_POST["codice_user"]) . "";
	$nome_scuola = $con->real_escape_string($_POST["nome_scuola"]) . "";
	$email = $con->real_escape_string($_POST["email"]) . "";
	$tabella_dati = $con->real_escape_string($_POST["tabella_dati"]) . "";
	
	
	
	
	$sql = "insert into {$tabella_codici} values(null,'{$codice_admin}','{$codice_s_admin}','{$codice_user}','{$tabella_dati}','{$nome_scuola}','{$email}')";
	$con->query($sql);
	
	$sql1 = "select * from {$tabella_codici}";
	$rs = $con->query($sql1);
	$r = $rs->fetch_assoc();
	
	
$sql = "CREATE TABLE IF NOT EXISTS {$r["nome_tabella"]} (
  `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `email_organizzatore` varchar(255) NOT NULL,
  `durata` bigint(12) NOT NULL,
  `nome_partecipante` varchar(255) NOT NULL,
  `esterno` tinyint(1) NOT NULL,
  `codice_riunione` varchar(20) NOT NULL,
  `client` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `data` (`data`),
  KEY `email_organizzatore` (`email_organizzatore`),
  KEY `nome_partecipante` (`nome_partecipante`)
) ENGINE=MyISAM AUTO_INCREMENT=1;";

$rit = $con->query($sql);
myalert("Installazione avvenuta con successo...","index.php");	
	
}


 ?>
</head>
<body>
   <!-- CONTENUTO DELLA PAGINA ... -->
   
   <div class="container-fluid">
     
	
		<div class="row">
		   <div class="col-xs-12  col-md-6 col-lg-5 bg-primary" style="margin:10px;padding:20px;" id="divform">
				<h3 class="alert alert-info text-center">Installazione applicazione monitoraggio dati Google Meet</h3>
				<form id="forminstall" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
														
					<div class="form-group">
						<label for="codice_s_admin">Codice per super admin</label>
						<input required type="text"   class="form-control" id="codice_s_admin" name="codice_s_admin">
						
					</div>
					
					<div class="form-group">
						<label for="codice_admin">Codice per admin</label>
						<input required type="text"   class="form-control" id="codice_admin" name="codice_admin">
						
					</div>
					
					<div class="form-group">
						<label for="codice_user">Codice per normal user</label>
						<input required type="text"   class="form-control" id="codice_user" name="codice_user">
						
					</div>
					
					<div class="form-group">
						<label for="nome_scuola">Nome scuola</label>
						<input required type="text"   class="form-control" id="nome_scuola" name="nome_scuola">
						
					</div>
					
					<div class="form-group">
						<label for="email">E-mail</label>
						<input required type="email"   class="form-control" id="email" name="email">
						
					</div>
					
					<div class="form-group">
						<label for="tabella_dati">Nome tabella dati meet</label>
						<input required type="text"   class="form-control" id="tabella_dati" name="tabella_dati">
						
					</div>
					
										
					<div class="form-group">
					<input type="submit" id="submit" name="submit" class="btn btn-success" value="INVIA">
					</div>
					
				</form>
		  </div>
		</div>
		
	
	
		
   </div>
  <!-- JS -->
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  
  
  <!-- JS -->
   
  
</body>
</html>