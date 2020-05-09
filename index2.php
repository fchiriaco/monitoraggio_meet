<?php 
session_start();
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	header("location: index.php");
$tabella = $_SESSION["tabella"];
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
  
  
  <style type="text/css">
  
	 #divform, #divfile, #divcodice_riunione, #divemail_organizzatore,#divnome_partecipante,#divrisultati,#divwait, #divriep_date  
	  
	   {
		   display:none;
		   
		   }
  
  </style>
  
  <!-- CSS -->  

  <?php
    include("configlocale.php");
 ?>
</head>
<body>
   <!-- CONTENUTO DELLA PAGINA ... -->
   
   <div class="container-fluid">
     <div id="menu">
		<h1 class="alert alert-info text-center" style="margin:0px;margin-bottom:5px;border:solid 2px #ffffff;border-radius:10px;"><?php echo $pagetitle ?><br><small>Programmed by Francesco Chiriaco</small></h1>
		
		<div class="row">
		 <div class="col-xs-12">
		  <hr>
		  <div class="dropdown">
			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Procedure attive
							<span class="caret"></span>
			</button>
				<ul class="dropdown-menu" role="menu">
					<?php if($_SESSION["admin"]) { ?>
					<li><a style="background:#17a2b8;color:#ffffff" href="#" id="csv">Upload dati da CSV Generato da G SUITE</a></li>
					<li><a style="background:#4cae4c;color:#ffffff" href="utenze/index.php" id="utenze">Gestione utenze scuole</a></li>
					<li><a style="background:#dc3545;color:#ffffff" href="truncate.php" id="truncate">Cancella tutti i dati dal database</a></li>
					<?php } ?>
					<li><a href="#" id="riepilogodatiriunione">Riepilogo dati riunione</a></li>
					<li><a href="#" id="presentiriunione">Presenti alla riunione</a></li>
					<?php if(!$_SESSION["user"]) { ?>
					<li><a href="#" id="riepilogoorganizzatore">Riepilogo riunioni di un dato organizzatore</a></li>
					<li><a href="#" id="riepilogopartecipante">Riepilogo per nome partecipante</a></li>
					<li><a href="#" id="riepilogodate">Riepilogo riunioni per data</a></li>
					<?php } ?>
					<li><a href="#" id="logout">Chiudi sessione</a></li>
				</ul>
		  </div>
		  <hr>
		 </div>
		</div>
	 </div>
	 
		<div class="row">
		   <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4 bg-primary" style="margin:10px;padding:20px;" id="divform">
				<form id="mainform" action="" method="POST" enctype="multipart/form-data">
					
					
					<div class="form-group" id="divfile">
						<label for="file">File csv esportato dalla console di G SUITE</label>
						<input type="file"  class="form-control" id="file" name="file">
					</div>
					
					<div class="form-group" id="divcodice_riunione">
						<label for="codice_riunione">Codice riunione</label>
						<input type="text"   class="form-control" id="codice_riunione" name="codice_riunione">
						
						<div class="form-group">
							<div class="row">
							<div class="col-xs-12 col-sm-4">
							<label for="datariunione">Data riunione</label><input   class="form-control" type="text" name="datariunione" id="datariunione">
							</div>
							</div>
					    </div>
						
					</div>
					
					<div class="form-group" id="divcodice_riunione2">
						<label for="codice_riunione2">Codice riunione</label>
						<input type="text"   class="form-control" id="codice_riunione2" name="codice_riunione2">
						
						<div class="form-group">
							<div class="row">
							<div class="col-xs-12 col-sm-4">
							<label for="datariunione2">Data riunione</label><input   class="form-control" type="text" name="datariunione2" id="datariunione2">
							</div>
							</div>
					    </div>
						
					</div>
					
							
					<div class="form-group" id="divemail_organizzatore">
						<label for="email_organizzatore">Email organizzatore</label>
						<input type="text"   class="form-control" id="email_organizzatore" name="email_organizzatore">
						<div class="form-group">
							<div class="row">
							<div class="col-xs-12 col-sm-4">
							<label for="dinizio">Data inizio</label><input  class="form-control" type="text" name="dinizio" id="dinizio"> <label for="dfine">Data fine</label><input class="form-control"  type="text" name="dfine" id="dfine">
							</div>
							</div>
					    </div>
						
					</div>
					
					<div class="form-group" id="divnome_partecipante">
						<label for="nome_partecipante">Nominativo partecipante</label>
						<input type="text"   class="form-control" id="nome_partecipante" name="nome_partecipante">
						<div class="form-group">
							<div class="row">
							<div class="col-xs-12 col-sm-4">
							<label for="diniziop">Data inizio</label><input  class="form-control" type="text" name="diniziop" id="diniziop"> <label for="dfinep">Data fine</label><input class="form-control"  type="text" name="dfinep" id="dfinep">
							</div>
							</div>
					    </div>
						
					</div>
					
					<div class="form-group" id="divriep_date">
						
						<div class="form-group">
							<div class="row">
							<div class="col-xs-12 col-sm-4">
							<label for="diniziod">Data inizio</label><input  class="form-control" type="text" name="diniziod" id="diniziod"> <label for="dfined">Data fine</label><input class="form-control"  type="text" name="dfined" id="dfined">
							</div>
							</div>
					    </div>
						
					</div>
					
					
					
					<div class="form-group">
					<input type="submit" class="btn btn-success" value="INVIA">
					</div>
					
			</form>
		  </div>
		</div>
		
	<div id="divrisultati">
		<div class="row">
			<div class="col-xs-12" id="contenuti">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 text-center">
				<hr>
			  <a id="newrequest" href="#" class="btn btn-primary">NUOVA RICERCA <span class="glyphicon glyphicon-search"></span></a>
			</div>
		</div>
	</div>
	
	<div id="divwait">
		<div class="row">
			<div class="col-xs-12 text-center">
			 <img src="load.gif">
			</div>
		</div>
		
	</div>
	
		
   </div>
  <!-- JS -->
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/jquery.ui.datepicker-it.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
  
  <!-- JS -->
   
  
</body>
</html>