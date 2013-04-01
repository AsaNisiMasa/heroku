<?php // Módulo de conexión a la base de datos de la aplicación.

// CREDENCIALES DE ACCESO A LA BASE DE DATOS

$db_hostname = 'localhost';
$db_database = 'jornadas';
$db_username = 'nacho';
$db_password = 'zerkalo';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die ("Unable to connect to MySQL" . mysql_error());

mysql_select_db($db_database, $db_server)
	or die ("Unable to select database" . mysql_error());
?>