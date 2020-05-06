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
  
  
  
  
  <!-- CSS -->  

  <?php
    include("configlocale.php");
 ?>
</head>
<body>
   <!-- CONTENUTO DELLA PAGINA ... -->
   
   <div class="container-fluid">
     		
	<div id="divrisultati">
		<div class="row">
			<div class="col-xs-12" id="contenuti">
				<?php include("incdatiriunione.php"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 text-center">
				<hr>
			  <a href="#" class="btn btn-danger" onclick="window.close();">TORNA ALL'ELENCO <span class="glyphicon glyphicon-remove"></span></a>
			  <hr>
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