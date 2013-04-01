<?php

date_default_timezone_set('UTC');

session_start();

if(isset($_POST['log_user'])&&isset($_POST['log_pass'])){
	
	$log_user = mysql_real_escape_string($_POST['log_user']);
	$log_pass = mysql_real_escape_string($_POST['log_pass']);

	include 'conect_to_database.php';

	$query = "SELECT * FROM usuarios WHERE username='$log_user'";
	$result = mysql_query($query);

	if(!$result) die ("Database access failed:" . mysql_error());

	if (mysql_num_rows($result) < 1){
		$message = "Identificacion incorrecta";
		$_SESSION = array();
		if(session_id() != "" || isset($_COOKIE[session_name()]))
			setcookie(session_name(), '', time() - 60 * 60 * 24 * 30, '/');
		session_destroy();
	}
	else {
		$row = mysql_fetch_row($result);
	
		if(!($log_user==$row[0]&&$log_pass==$row[1])){
			$message = "Identificacion incorrecta";
			$_SESSION = array();
			if(session_id() != "" || isset($_COOKIE[session_name()]))
				setcookie(session_name(), '', time() - 60 * 60 * 24 * 30, '/');
			session_destroy();
		}
		else{
			$_SESSION['username'] = $log_user;
			$message = "Identificado como: $log_user";
		}
	}
	
	mysql_close($db_server);
}

if(isset($_POST['logout'])){
	$_SESSION = array();
	if(session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time() - 60 * 60 * 24 * 30, '/');
	session_destroy();
}
?>




<?php
if(isset($_POST['reg_user'])&&isset($_POST['reg_pass'])){

	$user_reg = mysql_real_escape_string($_POST['reg_user']);
	$pass_reg = mysql_real_escape_string($_POST['reg_pass']);
	
	include 'conect_to_database.php';
	
	$query = "SELECT * FROM usuarios WHERE username='$user_reg'";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed" . mysql_error());
	
	if(mysql_num_rows($result) > 0) {
		$message = "Ya existe un usuario registrado con ese nombre.";
	}	
	else {
		$query = "INSERT INTO usuarios (username, password) VALUES ('$user_reg', '$pass_reg')";
		$result = mysql_query($query);
		if (!$result) die ("Database access failed" . mysql_error());
		
		$_SESSION['username'] = $user_reg;
	}
	mysql_close($db_server);
	
}
?>

<?php

if(isset($_POST['jornada'])){
	
	if(isset($_SESSION['username'])){
		
			$username=mysql_real_escape_string($_SESSION['username']);
			
			include 'conect_to_database.php';
			
			if($username == 'anonimo') {
				$query = "SELECT * FROM datos WHERE username LIKE 'anonimo%'";
				
				$result = mysql_query($query);
				
				if(!$result) die ("Database access failed: " .mysql_error());
				
				$username = $username . (mysql_num_rows($result) + 1);
				
				$_SESSION['username'] = $username;
				
			}
			
			$jornada = mysql_real_escape_string($_POST['jornada']);
			
			$query = "SELECT * FROM datos WHERE username='$username' AND jornada=$jornada";
			
			$result = mysql_query($query);
			
			if(!$result) die ("Database access failed: " .mysql_error());
			
			if(mysql_num_rows($result) < 1) {

				$query = "INSERT INTO datos (username, jornada) VALUES ('$username', $jornada)";
			
				$result = mysql_query($query);
			
				if(!$result) die ("Database access failed: " . mysql_error());
			}
			
			for($i = 1 ; $i <= 15; ++$i){
				
				$match = mysql_real_escape_string($_POST['match'.$i]);
				$query = "UPDATE datos SET match$i='$match' WHERE username='$username' AND jornada=$jornada";
				
				$result = mysql_query($query);
			
				if(!$result) die ("Database access failed: " . mysql_error());
			}
	}
		
mysql_close($db_server);
	
}


?>


<!doctype html>
<html>
<head>
	<title>Proyecto Delfos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<link rel='stylesheet' type='text/css' href='css/login.css' />
	<!--link rel='stylesheet' type='text/css' href='quiniela.css' /-->
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>



<?php
if(!isset($_SESSION['username'])) {

?>
	
<link rel='stylesheet' type='text/css' href='css/style.css' />
<link rel='stylesheet' type='text/css' href='css/prompt.css' />
<link rel='stylesheet' type='text/css' href='css/quiniela.css' />


	<script type="text/javascript">

		$(function (){

			$('#main').load('void.php', function(){
				$('#main').css('opacity', '0.3');
				$('#prompt').load('prompt.php');			
			});
			
			

		});
	</script>

<?php
}
else {
?>

<link rel='stylesheet' type='text/css' href='css/style.css' />



<script type="text/javascript">

	$(function (){
		
		$('#main').load('selector.php');
		
		$('#logout').on('click', function(){
			$.post('/index.php', { logout: true }).done(function(){
				location.reload();
			});
		});
		
		$('#HOME').on('click', function(){
			$('#main').load('selector.php');
		});
		
		$('#JORNADAS').on('click', function(){
			$('#main').load('jornadas.php');
		});
		
		$('#CONFIG').on('click', function(){
			$('#main').load('config.php');
		});
		
	});
</script>

<?php
}
?>




</head>
<body>	

	<nav>
		<div class="nav_but" id="HOME">
			<img src="img/home.png" width="40px" height="40px">
		</div>
		<div class="nav_but" id="JORNADAS">
			JORNADAS
		</div>
		<div class="nav_but" id="CONFIG">
			CONFIGURACIÓN
		</div>
		<span id="title"><div>PROYECTO DELFOS</div><span>1</span><span>X</span><span>2</span></span>
		
<?php

if(isset($_SESSION['username'])) {

echo <<<HTML
		<div id="logout">
			<img src="img/log-out.png" width="50px" height="50px">
		</div>
HTML;
}
?>
	</nav>

	<div class="section" id="main">

	</div>
	
	<div class="section" id="sidebar">
		
	</div>
	
	<div id="prompt" status="normal">
			
	</div>
	
</body>
</html>