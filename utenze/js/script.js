$(document).ready(function(){
	
	
						carica_dati("");
						
						$(document).on('click','.delete',function(e){
							e.preventDefault();
							r = confirm('Sei sicuro di voler eliminare il record?');
							if(r)
							{
								chiave = $(this).attr('href');
								$.post('eliminarecord.php',{'chiave':chiave},function(data){
									alert(data);
									$('#sendricerca').trigger('click'); 
								});
							}
						});
						
						$('#formsearch').submit(function(e){
																
																e.preventDefault();
																$('#recstart').val(0);
																var formData = new FormData($(this)[0]);
																
																$.ajax({
																			url: 'search.php',
																			type: 'POST',
																			data: formData,
																			async: true,
																			cache: false,
																			contentType: false,
																			processData: false,
																			success: function (returndata) {
																							
																							$('#dati').html(returndata);
																	
																						}
																		});
																return false;
															});
															
						$(document).on('click','#right',function(e){
							
							$('#recstart').val($(this).attr('posright'));
							
							arricerca = [];
							i = 0;
							$('#formsearch input').each(function(index){
								campo = $(this).attr('id')
								if(campo != "recstart" && campo != "recvisualizzati" && campo != "sendricerca")
								{
									arricerca.push($(this).val());
									
									i++;
								}
							});	
							
							carica_dati(arricerca);
							
						});
						
						$(document).on('click','#left',function(e){
							
							$('#recstart').val($(this).attr('posleft'));
							
							var arricerca = [];
							var i = 0;
							$('#formsearch input').each(function(index){
								campo = $(this).attr('id')
								if(campo != "recstart" && campo != "recvisualizzati" && campo != "sendricerca")
								{
									arricerca.push($(this).val());
									
									i++;
								}
							});		
							carica_dati(arricerca);
						});
						
						
						$(document).on('click','#addrec',function(e){
							
							
							$('.canreset').val('');
							$('#contenitore').css("opacity","0.2");
							$(document).scrollTop(0);
							$('#datiadd').slideDown('slow');
							$('#datiadd').scrollTop(0);
							
						});
						
						$(document).on('click','#rinuncia',function(e){
							
							
							
							$('#contenitore').css("opacity","1");
							$('#datiadd').slideUp('slow');
							
							
						});
						
						
						
						
						
						$('#frmadd').submit(function(e){
																
																e.preventDefault();
																
																var formData = new FormData($(this)[0]);
																
																$.ajax({
																			url: 'salvarec.php',
																			type: 'POST',
																			data: formData,
																			async: true,
																			cache: false,
																			contentType: false,
																			processData: false,
																			success: function (returndata) {
																							alert(returndata);
																							if(returndata.substr(0,6).toLowerCase() != "errore")
																							{
																								$('#recstart').val(0);
																								$('#contenitore').css("opacity","1");
																								$('#datiadd').slideUp('slow');
																								$('#sendricerca').trigger('click');
																							}
																						}
																		});
																return false;
															});
						
						
						$(document).on('click','.edit',function(e){
							
							e.preventDefault();
							chiave = $(this).attr("href");
							$.post('formupdate.php',{'chiave':chiave},function(data){
								
								$('#datiupd').html(data);
								
								$('#contenitore').css("opacity","0.2");
								$(document).scrollTop(0);
								$('#datiupd').slideDown('slow');
								$('#datiupd').scrollTop(0);
							});
							
							
						});
						
						$(document).on('click','#rinunciaupd',function(e){
							
							
							
							$('#contenitore').css("opacity","1");
							$('#datiupd').slideUp('slow');
							
							
						});
						
						
						
						
						$(document).on('submit','#frmupd',function(e){
																
																e.preventDefault();
																
																var formData = new FormData($(this)[0]);
																
																$.ajax({
																			url: 'updaterecord.php',
																			type: 'POST',
																			data: formData,
																			async: true,
																			cache: false,
																			contentType: false,
																			processData: false,
																			success: function (returndata) {
																							alert(returndata);
																							if(returndata.substr(0,6).toLowerCase() != "errore")
																							{
																								$('#recstart').val(0);
																								$('#contenitore').css("opacity","1");
																								$('#datiupd').slideUp('slow');
																								$('#sendricerca').trigger('click');
																							}
																						}
																		});
																return false;
															});
						
						
						
});

function carica_dati(arricerca)
{
	var numcampiric = "";
	var stringapost= "";
	if(Array.isArray(arricerca))
	{
		
		numcampiric = arricerca.length;
		
		for(i = 0;i < numcampiric;i++)
		{
			if(i > 0)
				stringapost +=  "|" + arricerca[i];
			else	
				stringapost +=  arricerca[i];
		}
	}
	
	righevis = $('#recvisualizzati').val() + "";
	start = $('#recstart').val() + "";
	
	$.post("caricadati.php",{'campiricerca':stringapost,'start':start,'righe':righevis},function(data){$('#dati').html(data);})
}