<!doctype html>
<html>

<?php
date_default_timezone_set('UTC');

include 'conect_to_database.php';

if(isset($_POST['jornada'])){

	$jornada = mysql_real_escape_string($_POST['jornada']);

	$query = "SELECT 1 FROM jornadas WHERE jornada = $jornada";
	$result = mysql_query($query);
	if (!$result) die ("Database access failed" . mysql_error());

	if(mysql_num_rows($result) < 1){
		$query = "INSERT INTO jornadas (jornada) VALUES ($jornada)";
		$result = mysql_query($query);
		if (!$result) die ("Database access failed" . mysql_error());	
	}

	for ($i = 1 ; $i <= 15; ++$i){
			
		$match = mysql_real_escape_string($_POST['match'.$i]);
		
		$query = "UPDATE jornadas SET match$i ='". $match ."' WHERE jornada = $jornada";
		$result = mysql_query($query);
		if (!$result) die ("Database access failed" . mysql_error());
	}
	
	$date = mysql_real_escape_string($_POST['date']);
	$query = "UPDATE jornadas SET date ='$date' WHERE jornada = $jornada";
	$result = mysql_query($query);
	if (!$result) die ("Database access failed" . mysql_error());
	
	$status = mysql_real_escape_string($_POST['status']);
	$query = "UPDATE jornadas SET status ='$status' WHERE jornada = $jornada";
	$result = mysql_query($query);
	if (!$result) die ("Database access failed" . mysql_error());
}

?>


<head>
	<title>Datos para la base de datos.</title>
	<link rel='stylesheet' type='text/css' href='css/jornadas.css' />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

	<script type="text/javascript">
	
		$(function(){
				$('#stat_but').on('click', function(){
					if ($('input[name=status]').attr('value') == 'open'){
						$('input[name=status]').attr('value', 'close');
						$('#stat_but').attr('status', 'close');
					}
					else {
						$('input[name=status]').attr('value', 'open');
						$('#stat_but').attr('status', 'open');
					}
				});

				$('#cancel').on('click', function(){

					$('#main').load('jornadas.php');
				});

				$('#erase').on('click', function(){

					var jorn = $('input[name="jornada"]').val();

					$.get('fill.php?jornada=' + jorn + "&erase=true");
					$('#main').load('jornadas.php');
				});

				$('#save').on('click', function(){

					var jorn = $('input[name="jornada"]').val(),
						m1 = $('input[name="local_1"]').val() + '|' + $('input[name="visitante_1"]').val(),
						m2 = $('input[name="local_2"]').val() + '|' + $('input[name="visitante_2"]').val(),
						m3 = $('input[name="local_3"]').val() + '|' + $('input[name="visitante_3"]').val(),
						m4 = $('input[name="local_4"]').val() + '|' + $('input[name="visitante_4"]').val(),
						m5 = $('input[name="local_5"]').val() + '|' + $('input[name="visitante_5"]').val(),
						m6 = $('input[name="local_6"]').val() + '|' + $('input[name="visitante_6"]').val(),
						m7 = $('input[name="local_7"]').val() + '|' + $('input[name="visitante_7"]').val(),
						m8 = $('input[name="local_8"]').val() + '|' + $('input[name="visitante_8"]').val(),
						m9 = $('input[name="local_9"]').val() + '|' + $('input[name="visitante_9"]').val(),
						m10 = $('input[name="local_10"]').val() + '|' + $('input[name="visitante_10"]').val(),
						m11 = $('input[name="local_11"]').val() + '|' + $('input[name="visitante_11"]').val(),
						m12 = $('input[name="local_12"]').val() + '|' + $('input[name="visitante_12"]').val(),
						m13 = $('input[name="local_13"]').val() + '|' + $('input[name="visitante_13"]').val(),
						m14 = $('input[name="local_14"]').val() + '|' + $('input[name="visitante_14"]').val(),
						m15 = $('input[name="local_15"]').val() + '|' + $('input[name="visitante_15"]').val(),
						fecha = $('input[name="fecha"]').val(),
						stat = $('input[name="status"]').val();

					$.post($('#data').attr('action') ,{	jornada: jorn,
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
														match15: m15,
														date: fecha,
														status: stat }).done(function(){
															$('#main').load('jornadas.php');
														});
					//$('#main').load('jornadas.php');
				});

				$('#data').submit(function(e){

					e.preventDefault();

				});
		});
		
	</script>
	
</head>

<body>
	
		
		<form id="data" method="POST" action="fill.php" accept-charset="UTF-8">

<?php

	if(isset($_GET['jornada'])){

		$jornada = mysql_real_escape_string($_GET['jornada']);
		
		if(isset($_GET['erase'])){
			
			
			$query="DELETE FROM jornadas WHERE jornada= $jornada";
			
			$result = mysql_query($query);
			
			if(!$result)
				die ("Database access failed:" .mysql_error());
			else die ("Se ha eliminado la jornada: $jornada");
		}
		
	}
	else {
		
		$jornada = 0;
	}
	
	
	$_jornada = $jornada == -1 ? ' ' : $jornada;
	
	$query = "SELECT * FROM jornadas WHERE jornada = $jornada";
	
	$result = mysql_query($query);
	
	if(!$result) die ("Database access failed: " . mysql_error());
	
	$row = mysql_fetch_row($result);
	$n = mysql_num_rows($result);
	
	$date = $row[16];
	$status = $row[17];
	

echo <<<HTML
			<div id="jorn_date">
				<div id="jornada">
					<label>Jornada&nbsp<input type="text" name="jornada" size="2" value="$_jornada"></input></label>
				</div>
				<div id="fecha">
					<label>&nbsp&nbsp-&nbsp&nbsp<input type="text" name="fecha" size="24" value="$date"></input></label>
				</div>
				<div id="status">
					Status
					<div id="stat_but" status="$status">&nbsp&nbsp&nbsp&nbsp&nbsp<input type="hidden" name="status" value="$status"></input></div>
				</div>
			</div>
HTML;
?>

			

			<table>
				

<?php
		
	
	for ($i=1 ; $i <= 15 ; ++$i){
		
		$value1 ="";
		$value2 ="";
		
		if($n > 0) {
			
			$match = explode('|', $row[$i]);
			
			$value1 = $match[0];
			$value2 = $match[1];
		}
		
echo <<<HTML

<tr>
	<td class="num">$i</td>	
	<td class="match"><input type="text" name="local_$i" size="32" value="$value1"></input></td>
	<td class="sep">-</td>
	<td class="match"><input type="text" name="visitante_$i" size="32" value="$value2"></input></td>	
</tr>

HTML;
		
	}
	
	mysql_close($db_server);	

?>
			</table>
		</form>
		
		<div id ="control">
			<div class="butt" id="cancel">Cancelar</div>
			<div class="butt" id="erase">Borrar</div>
			<div class="butt" id="save">Guardar</div>
		</div>


</body>

</html>