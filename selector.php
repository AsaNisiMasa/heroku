<?php

date_default_timezone_set('UTC');

include 'conect_to_database.php';

if(isset($_GET['jornada'])){
	
	$jornada = mysql_real_escape_string($_GET['jornada']);
	$fecha = "No definido";
	$status = "close";
	
	$query = "SELECT * FROM jornadas WHERE jornada = $jornada";

	$result =  mysql_query($query);
	
	if(!$result) die ("Database access failed: " .mysql_error());

	if (mysql_num_rows($result) > 0){

		$jornada = mysql_result($result, 0, 'jornada');
		$fecha = mysql_result($result, 0, 'date');
		$status = mysql_result($result, 0, 'status');
	}

}
else{
	
	$query = "SELECT * FROM jornadas WHERE status='open' ORDER BY jornada";

	$result =  mysql_query($query);
	
	if(!$result) die ("Database access failed: " .mysql_error());

	if (mysql_num_rows($result) > 0){

		$jornada = mysql_result($result, 0, 'jornada');
		$fecha = mysql_result($result, 0, 'date');
		$status = 'open';
	}

	else {
		$jornada = 40; // JORNADA POR DEFECTO EN CASO DE QUE NO HAYA NINGUNA ACTIVA.
		$fecha = "domingo, 24/03/2013";
		$status = "close";
	}
}

mysql_close($db_server);
?>

<!doctype html>
<html>

<head>
	
	<title>Proyecto Delfos</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/animacion.css' />

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

	<script type="text/javascript">

		$(function(){ 
			var _jornada = <?php echo $jornada; ?>;
			var _status = '<?php echo $status; ?>';
			
			
			
			$('#jornada input[name=jornada]').attr('value', _jornada);		
			

			quiniela_eventos = function () {

				$('.row').on('click', function(){

					$(this).siblings().attr('sel', 'false'); // Deselecciona la fila anterior
					$('.row:not([chg=true])').attr('fix', 'false'); // Desbloquea las filas no cargadas.

					if ($(this).attr('sel') == 'true'){ // Selecciona/deselecciona la fila actual
						$(this).attr('sel', 'false'); 
						$(this).attr('fix', 'false');
					}
					else {
						$(this).attr('sel', 'true');
						$(this).attr('fix', 'true');
						if($('#alerta').attr('stat') == 'ini'){
							$('#alerta').attr('stat', 'sel');
							$('#alerta').html("Marque su predicción sobre el triángulo");
						}
					}
				});

			}


			$('#quiniela').load('quiniela.php?jorn='+ _jornada, function(){

				quiniela_eventos();

			});
			
			$('#selector').load('triangulo.php', function(){
				
				if(_status == 'open') {
					
					//$('#datos input[name=jornada]').attr('value', _jornada);
				
					$('area').on('click', function(){

						var pos = $(this).attr('pos'),
						 	val1 = $(this).attr('val_1'),
							valx = $(this).attr('val_x'),
							val2 = $(this).attr('val_2');
						
						$('*[sel="true"] .pos.val').html(pos);
						$('*[sel="true"] .uno.val').html(val1);
						$('*[sel="true"] .x.val').html(valx);
						$('*[sel="true"] .dos.val').html(val2);

						$('*[sel="true"]').attr('chg', 'true');


					/*	var value = pos + '|' + val1 + '|' + valx + '|' + val2;

						$('input[name=' + $('*[sel="true"] .num').attr('id') + ']').val(value);
						
						$('#alerta').html('');
						$('#alerta').css('background-color', '#fbfbfb');*/

					});
				
					$('area').hover(function(){
						
						$('#alerta').hide();
						$('#visor').show();
						var val1 = $(this).attr('val_1'),
							valx = $(this).attr('val_x'),
							val2 = $(this).attr('val_2');
						
						$('#win1').html(val1);
						$('#winx').html(valx);	
						$('#win2').html(val2);		
					
					
					});
					
					$('area').mouseover(function(){
						$('#alerta').hide();
						$('#visor').show();
					});
					
					$('map').mouseleave(function(){
						$('#visor').hide();
						$('#alerta').show();
					
					});
				
					$('#send_but').on('click', function(){
						jorn = _jornada;
						m1 = $('.row[num="1"] .pos').html() + '|' + $('.row[num="1"] .val.uno').html() +'|'+ $('.row[num="1"] .val.x').html() + '|' + $('.row[num="1"] .val.dos').html();
						m2 = $('.row[num="2"] .pos').html() + '|' + $('.row[num="2"] .val.uno').html() +'|'+ $('.row[num="2"] .val.x').html() + '|' + $('.row[num="2"] .val.dos').html();
						m3 = $('.row[num="3"] .pos').html() + '|' + $('.row[num="3"] .val.uno').html() +'|'+ $('.row[num="3"] .val.x').html() + '|' + $('.row[num="3"] .val.dos').html();
						m4 = $('.row[num="4"] .pos').html() + '|' + $('.row[num="4"] .val.uno').html() +'|'+ $('.row[num="4"] .val.x').html() + '|' + $('.row[num="4"] .val.dos').html();
						m5 = $('.row[num="5"] .pos').html() + '|' + $('.row[num="5"] .val.uno').html() +'|'+ $('.row[num="5"] .val.x').html() + '|' + $('.row[num="5"] .val.dos').html();
						m6 = $('.row[num="6"] .pos').html() + '|' + $('.row[num="6"] .val.uno').html() +'|'+ $('.row[num="6"] .val.x').html() + '|' + $('.row[num="6"] .val.dos').html();
						m7 = $('.row[num="7"] .pos').html() + '|' + $('.row[num="7"] .val.uno').html() +'|'+ $('.row[num="7"] .val.x').html() + '|' + $('.row[num="7"] .val.dos').html();
						m8 = $('.row[num="8"] .pos').html() + '|' + $('.row[num="8"] .val.uno').html() +'|'+ $('.row[num="8"] .val.x').html() + '|' + $('.row[num="8"] .val.dos').html();
						m9 = $('.row[num="9"] .pos').html() + '|' + $('.row[num="9"] .val.uno').html() +'|'+ $('.row[num="9"] .val.x').html() + '|' + $('.row[num="9"] .val.dos').html();
						m10 = $('.row[num="10"] .pos').html() + '|' + $('.row[num="10"] .val.uno').html() +'|'+ $('.row[num="10"] .val.x').html() + '|' + $('.row[num="10"] .val.dos').html();
						m11 = $('.row[num="11"] .pos').html() + '|' + $('.row[num="11"] .val.uno').html() +'|'+ $('.row[num="11"] .val.x').html() + '|' + $('.row[num="11"] .val.dos').html();
						m12 = $('.row[num="12"] .pos').html() + '|' + $('.row[num="12"] .val.uno').html() +'|'+ $('.row[num="12"] .val.x').html() + '|' + $('.row[num="12"] .val.dos').html();
						m13 = $('.row[num="13"] .pos').html() + '|' + $('.row[num="13"] .val.uno').html() +'|'+ $('.row[num="13"] .val.x').html() + '|' + $('.row[num="13"] .val.dos').html();
						m14 = $('.row[num="14"] .pos').html() + '|' + $('.row[num="14"] .val.uno').html() +'|'+ $('.row[num="14"] .val.x').html() + '|' + $('.row[num="14"] .val.dos').html();
						m15 = $('.row[num="15"] .pos').html() + '|' + $('.row[num="15"] .val.uno').html() +'|'+ $('.row[num="15"] .val.x').html() + '|' + $('.row[num="15"] .val.dos').html();
					
						$.post($('#datos').attr('action'), { jornada: jorn,
												match1: m1,
												match2: m2,
												match3: m3,
												match4: m4,
												match5: m5,
												match6: m6,
												match7: m7,
												match8: m8,
												match9: m9,
												match10: m10,
												match11: m11,
												match12: m12,
												match13: m13,
												match14: m14,
												match15: m15 });
						$('#alerta').html("Sus predicciones se han registrado correctamente. Gracias por participar.");
						$('#alerta').css('background-color', '#ffffcc');
						$('#alerta').show();
						$('#alerta').fadeOut(3000);
					});
						
				}
				else if (_status == 'close') {
					$(this).css('opacity', '0.3');
					$('#send_but').css('cursor', 'default');
					$('img').attr('usemap', '');
				}
			});

			
			$('#jorn_selection').submit(function(e){
				
				e.preventDefault();
				
				$.get('selector.php?jornada='+$('#jornada input[name=jornada]').val(), function(response){
					$('#main').html(response);
				});
				
			});
			
			$('#decr').on('click', function(){
			
				_jornada--;
				
				$('#main').load('selector.php?jornada=' + _jornada);
			});
			
			$('#incr').on('click', function(){
			
				_jornada++;
				
				$('#main').load('selector.php?jornada=' + _jornada);
			});

			
		});

	</script>	

</head>
<body>


<div id="jorn_select">
	
	<div id="decr">
		<img src='img/left2.png'>
	</div>

	<div id="jornada">
		<form id="jorn_selection" action="selector.php">
			<label>Jornada<input type="text" name="jornada" value="" size="2"></input></label>
		</form>
	</div>
	
	<div id="fecha">
<?php echo ' - ' . $fecha; ?>
	</div>
	
	<div id="incr">
		<img src='img/right2.png'>
	</div>

</div>

<div id="quiniela"></div>

</body>

<div id="selector">

</div>



</html>