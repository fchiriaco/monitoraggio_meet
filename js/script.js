$(document).ready(function(){
	
	var azione = 0;
	var azioni = ["uploadcsv.php","riepilogo_riunione.php","riepilogo_presenze.php","riepilogo_organizzatore.php","riepilogo_partecipante.php"];
	
		
		$('#mainform').submit(
		function(e){
			
						
						e.preventDefault();
						
						
						
						
						var formData = new FormData($(this)[0]);
						$('#divform').hide();
						$('#divwait').show(); 
						$.ajax({
								url: azioni[azione-1],
								type: 'POST',
								data: formData,
								async: true,
								cache: false,
								contentType: false,
								processData: false,
								success: function (returndata) {
									
										$('input:text').val('');
										$('#file').val('');
										$('#contenuti').html(returndata);
										$('#menu').hide();
										$('#divform').hide();
										$('#divwait').hide();
										$('#divrisultati').show();
								}
							});
						return false;
					});
					
					
	$('#formautentica').submit(
		function(e){
			
						
						e.preventDefault();
						
						
						
						
						var formData = new FormData($(this)[0]);
						
						$.ajax({
								url: 'autentica.php',
								type: 'POST',
								data: formData,
								async: true,
								cache: false,
								contentType: false,
								processData: false,
								success: function (returndata) {
									
										if(returndata == "1")
											window.location.href= "index2.php";
										else
											alert("Codice errato...");
								}
							});
						return false;
					});
					
			

	
	
	$('#newrequest').click(function(e){
		e.preventDefault();
		$('#divrisultati').hide();
		$('#menu').show();
		
		return false;
				
	})
	
	$( "#dinizio" ).datepicker( $.datepicker.regional[ "it" ] );	
	$( "#diniziop" ).datepicker( $.datepicker.regional[ "it" ] );	
	
	$( "#datariunione" ).datepicker( $.datepicker.regional[ "it" ] );	
	$( "#datariunione2" ).datepicker( $.datepicker.regional[ "it" ] );	
	
	
	$( "#dfine" ).datepicker( $.datepicker.regional[ "it" ] );	
	$( "#dfinep" ).datepicker( $.datepicker.regional[ "it" ] );	
	
	$( "#dinizio" ).change(function(){
				
				$( "#dfine" ).datepicker( "option", "minDate", $( "#dinizio" ).datepicker("getDate")) ;
		
	});
	
	
	$( "#dfine" ).change(function(){
				
				$( "#dinizio" ).datepicker( "option", "maxDate", $( "#dfine" ).datepicker("getDate")) ;
		
	});
	
	
	
	$( "#diniziop" ).change(function(){
				
				$( "#dfinep" ).datepicker( "option", "minDate", $( "#diniziop" ).datepicker("getDate")) ;
		
	});
	
	
	$( "#dfinep" ).change(function(){
				
				$( "#diniziop" ).datepicker( "option", "maxDate", $( "#dfinep" ).datepicker("getDate")) ;
		
	});
	
	
	
	
	
	
	
	
	$('#csv').click(function() {
		
		$('#divform').show();
		$('#divcodice_riunione').hide();
		$('#divcodice_riunione2').hide();
		$('#divemail_organizzatore').hide();
		$('#divnome_partecipante').hide();
		$('#divfile').show();
		azione = 1;
		
	});
	
	$('#riepilogodatiriunione').click(function() {
		
		$('#divform').show();
		$('#divfile').hide();
		$('#divcodice_riunione2').hide();
		$('#divemail_organizzatore').hide();
		$('#divnome_partecipante').hide();
		$('#divcodice_riunione').show();
		
		azione = 2;
		
	});
	
	$('#presentiriunione').click(function() {
		
		$('#divform').show();
		$('#divfile').hide();
		$('#divcodice_riunione').hide();
		$('#divemail_organizzatore').hide();
		$('#divnome_partecipante').hide();
		$('#divcodice_riunione2').show();
		
		azione = 3;
		
	});
	
	$('#riepilogoorganizzatore').click(function() {
		
		$('#divform').show();
		$('#divfile').hide();
		$('#divcodice_riunione').hide();
		$('#divcodice_riunione2').hide();
		$('#divnome_partecipante').hide();
		$('#divemail_organizzatore').show();
		
		azione = 4;
		
	});
	
	
	$('#riepilogopartecipante').click(function() {
		
		$('#divform').show();
		$('#divfile').hide();
		$('#divcodice_riunione').hide();
		$('#divcodice_riunione2').hide();
		$('#divemail_organizzatore').hide();
		$('#divnome_partecipante').show();
		azione = 5;
		
	});
	
	$('#logout').click(function() {
		
		$('#divform').hide();
		$('#divfile').hide();
		$('#divcodice_riunione').hide();
		$('#divcodice_riunione2').hide();
		$('#divemail_organizzatore').hide();
		$('#divnome_partecipante').hide();
		$.get( "logout.php", function( data ) {
					window.location.href="index.php";
					
				});		
	});
	
	
	
});