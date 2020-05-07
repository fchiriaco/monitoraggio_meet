<?php 
session_start();
if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== true || !isset($_SESSION["codice_scuola"]) || empty($_SESSION["codice_scuola"]))
	header("location: index.php");
$tabella = $_SESSION["tabella"];
if(!$_SESSION["admin"])
	exit;
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
	
	
 ?>
</head>
<body>
   <!-- CONTENUTO DELLA PAGINA ... -->
   
   <div class="container-fluid">
     		
	<div >
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-sm-offset-2">
				<h3 class="alert alert-danger text-center"><strong>Attenzione tutti i dati presenti nel database verranno eliminati!!!!</strong></h3>
				<p class="text-center"> <b>Sei sicuro di volerli eliminare?</b> <a style="width:100px;" class="btn btn-success" href="index2.php">NO</a> <a style="width:100px;" class="btn btn-danger" href="truncate2.php">S&Igrave;</a></p>
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