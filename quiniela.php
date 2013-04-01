<?php // Módulo que construye la tabla de la quiniela mediante consulta a la base de datos.

if(isset($_GET['jorn'])){
	$jornada = $_GET['jorn'];
}
else{
	$jornada = 38;
}

include 'conect_to_database.php';

$query = "SELECT * FROM jornadas WHERE jornada = $jornada"; // Consulta
$result = mysql_query($query);

if(!$result) die ("Database acccess failed: " . mysql_error());

$p = mysql_num_rows($result);
$jorn_row = mysql_fetch_row($result);

$q=0;

session_start();

if(isset($_SESSION['username'])){
	
	$username = mysql_real_escape_string($_SESSION['username']);
	
	if($username != 'anonimo') {
		$query = "SELECT * FROM datos WHERE username='$username' AND jornada=$jornada";	
		$result = mysql_query($query);
	
		if(!$result) die ("Database acccess failed: " . mysql_error());
	
		$q = mysql_num_rows($result);
		$user_row = mysql_fetch_row($result);
	}
}
	
for ($n = 1 ; $n <= 15 ; ++$n) {

$match = $p > 0 ? explode("|",$jorn_row[$n])[0].'-'.explode("|",$jorn_row[$n])[1] : 'No definido.';
$pos = $q > 0 ? explode("|", $user_row[$n+1])[0] : "0";
$val1 = $q > 0 ? explode("|", $user_row[$n+1])[1] : "0.00";
$valx = $q > 0 ? explode("|", $user_row[$n+1])[2] : "0.00";
$val2 = $q > 0 ? explode("|", $user_row[$n+1])[3] : "0.00";

$chg  = $pos != "0" ? "true" : "false"; 
$fix  =  $chg;


echo <<<HTML

<div class="row" sel="false" num="$n" fix='$fix' chg='$chg'>
	<div class="three-d">
		<div aria-hidden="true" class="three-d-box">
			<div class="front">
				<div class="match">$match</div>
				<div class="guess">
					<span class="uno">1</span>
					<span class="x">X</span>
					<span class="dos">2</span>
				</div>
				<div class="num" id="match$n">$n</div>
			</div>
			<div class="back">
				<div class="match">$match</div>
				<div class="guess">
					<span class="pos val">$pos</span>
					<span class="uno val">$val1</span>
					<span class="x val">$valx</span>
					<span class="dos val">$val2</span>
				</div>
				<div class="num" id="match$n">$n</div>
			</div>
		</div>
	</div>		
</div>
				
HTML;
}

mysql_close($db_server);
?>