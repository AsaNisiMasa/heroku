<!doctype html>
<html>

<head>
	
	<title>Proyecto Delfos</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel='stylesheet' type='text/css' href='css/jornadas.css' />
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	
	<script type="text/javascript">
		$(function(){
			$('.jornada').on('click', function(){
				$('#fill').load('fill.php?jornada=' + $(this).attr('n'));
			});
		});
	</script>
	
</head>

<body>

	<div id="jorn_sel">

<?php

date_default_timezone_set('UTC');

include 'conect_to_database.php';

$query = "SELECT * FROM jornadas ORDER BY jornada";

$result = mysql_query($query);

if(!$result) die ("Database access failed: " .mysql_error());

$N = mysql_num_rows($result);

for($i = 0; $i < $N; ++$i){
	
	$jornada = mysql_result($result, $i, 'jornada');
	$status = mysql_result($result, $i, 'status');
	$fecha = mysql_result($result, $i, 'date');
	
echo <<<HTML
<div class = "jornada" n="$jornada" status="$status">
	Jornada $jornada
</div>
HTML;

}
?>		

		<div class = "new jornada" n="-1" status="close">
			+
		</div>

	</div>
	
	<div id="fill">

	</div>	
</body>

</html>