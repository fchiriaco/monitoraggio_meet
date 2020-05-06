<?php 
session_start();
if((isset($_SESSION["auth"]) && $_SESSION["auth"] === true) && (isset($_SESSION["codice_scuola"]) && !empty($_SESSION["codice_scuola"])))
	header("location: index2.php");
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
	$tokenmd5 = md5($token);
 ?>
</head>
<body>
   <!-- CONTENUTO DELLA PAGINA ... -->
   
   <div class="container-fluid">
     
	 <h1 class="alert alert-info text-center" style="margin:0px;margin-bottom:5px;border:solid 2px #ffffff;border-radius:10px;"><?php echo $pagetitle ?><br><small>Programmed by Francesco Chiriaco</small></h1>
		<div class="row">
		   <div class="col-xs-12 col-sm-7 col-md-6 col-lg-4 bg-primary" style="margin:10px;padding:20px;" id="divformautentica">
				<form class="form-inline" id="formautentica" action="" method="POST">
					
					
					
					
					<div class="form-group" id="divcodice_riunione">
						<input type="hidden" id="token" name="token" value="<?php echo $tokenmd5 ?>">
						<label for="codice_scuola">Codice scuola</label>
						
						<input type="password"   class="form-control" id="codice_scuola" name="codice_scuola"> <input type="submit" class="btn btn-success" value="INVIA">
						
						
						
						
					</div>
					
							
					
					
					
					
			</form>
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