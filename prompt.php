<!doctype html>
<html>
<head>
	<title>Proyecto Delfos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<link rel='stylesheet' type='text/css' href='css/login.css' />
	<!--link rel='stylesheet' type='text/css' href='quiniela.css' /-->
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

</head>

<body>

<div id="message">
	
	<div id="sideA">
		<form id="log_form" method="POST" action="">
			<label>Usuario:<input type="text" name="log_user"></label>
			<label>Contraseña:<input type="password" name="log_pass"></label>
		</form>
		<div class="control">
			<div class="button" id="log_but">Login</div>
			<div class="button" id="flip_but">Register</div>
			<div class="button" id="anon_but">Anónimo</div>
		</div>
	</div>
	
	<div id="sideB">
		<form id ="reg_form" method="POST" action="">
			<label>Usuario:<input type="text" name="reg_user"></label>
			<label>Contraseña:<input type="password" name="reg_pass"></label>
			<label>Confirmar:<input type="password" name="reg_conf"></input></label>
			<label>e-mail:<input type="text" name="reg_mail"></input></label>
		</form>
		<div class="control">
			<div class="button" id='cancel_but'>Cancelar</div>
			<div class="button" id='reg_but'>Registrarse</div>
		</div>
	</div>

</div>

<script type="text/javascript">	

	$('#flip_but').on('click', function(){
		$('#sideA').hide();
		$('#sideB').fadeIn(200);
	

	});
	
	$('#cancel_but').on('click', function(){
		
		$('#sideB').hide();
		$('#sideA').fadeIn(200);

	});
	
	$('#log_but').on('click', function(){
		$('#log_form').submit();
	});
	
	$('#anon_but').on('click', function(){
	
		$.post($('#log_form').attr('action'), { log_user: 'anonimo', log_pass: 12345 }).done(function(data){
			location.reload();
		});
	});

	
	$('#reg_but').on('click', function(){
		$('#reg_form').submit();
	});
	
</script>

</body>
</html>