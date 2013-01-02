<html>
<head>
<title>Votar foto</title>
</head>
<style>
body {
FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
}
A:link {
color:#525E6E;
FONT-FAMILY: Verdana, Helvetica;text-decoration:underline}
A:active {
color:#525E6E;
FONT-FAMILY: Verdana, Helvetica;text-decoration:underline}
A:visited {
color:#525E6E;
FONT-FAMILY: Verdana, Helvetica;text-decoration:underline}
A:hover {
color:#efefef;
FONT-FAMILY: Verdana, Helvetica;text-decoration:underline}
</style>
<body bgcolor="#66aef2" onLoad="window.opener.location.reload();window.close();">
<?php
$id= $_GET['id'];
ini_set('DISPLAY_ERRORS','0');
ini_set('error_reporting','E_ERROR');
//-- Conexión a la Base de datos
$conexio = mysql_connect("localhost","cd4046","");
mysql_select_db ($db, $conexio) OR die ("No se puede conectar al Servidor SQL");
//-- Contar cuantos registros hay
$conta="SELECT id FROM lasfotos";
$result2=mysql_query($conta,$conexio);
$quants=mysql_num_rows($result2);
?>
<?php
//-- Buscar 10 registros
$result=mysql_query($sql,$conexio);
mysql_query("update lasfotos set votos=votos+1 where id=\"$id\"");
    mysql_close ($conexio);
?>
