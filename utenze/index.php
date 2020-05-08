<?php session_start(); ?>
<?php

	
	include("configut.php");
	include("../configlocale.php");
	include("../util_func2.php");
	if(!isset($_SESSION["login"]) || $_SESSION["login"] != "AUT_1_2015#" || $_SESSION["uname"] != "admin")
	{
		session_destroy();
		header("location: {$dirsitoscript}login.php");
		exit;
	}
	
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<title><?php echo $pagetitle ?></title>

  <!-- META -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- META -->
  
  <!-- CSS -->
  <link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link type="text/css" href="css/style.css" rel="stylesheet" media="screen">
  <!-- CSS -->  
  
</head>
<body>
   <!-- CONTENUTO DELLA PAGINA ... -->
   <div class="container-fluid" id="contenitore">
				
		<div class="row">
			<div class="col-xs-12">
				<h1 class="alert alert-info text-center"><strong><?php echo $titolopg ?></strong></h1>
				
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12 text-center">
				<a class="btn btn-danger" href="<?php echo $_SERVER["HTTP_REFERER"]; ?>" title="Torna Indietro"><span class="glyphicon glyphicon-backward"></span></a>
				&nbsp;
				<a class="btn btn-danger" href="<?php echo $dirsitoscript ?>logout.php" title="Logout"> <span style class="glyphicon glyphicon-log-out"></span> </a>
				<br><br>
			</div>
		</div>	
		
		<div class="row">
			<div class="col-xs-12" id="searchbar">
				<?php include("searchbar.php"); ?>
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="col-xs-12" id="dati">
				
			</div>
		</div>
		
   </div>
   
   <div  id="datiadd">
				<?php include("formadd.php"); ?>
	</div>
	
	<div  id="datiupd">
				
	</div>
   
  <!-- JS -->
  <script src="../js/jquery-1.11.3.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
  <!-- JS -->
</body>
</html>