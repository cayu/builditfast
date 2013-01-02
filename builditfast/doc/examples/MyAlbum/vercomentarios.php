<html>
<head>
<title>Comentarios</title>
</head>
<style>
body {
    background: #66aef2;
	/*color:#000000;*/
	scrollbar-face-color: #ABBED1;
	scrollbar-arrow-color:  #46505E;
	scrollbar-track-color: #D1DCE7;
	scrollbar-highlight-color: #C8D3E1;
	scrollbar-3dlight-color: #EAEFF4;
	scrollbar-shadow-color: #7492B6;
	scrollbar-darkshadow-color: #3A5370;
	FONT-FAMILY: Verdana, Helvetica;
	text-decoration:none;
	font-size: 10px;
	}
.coment{
	FONT-FAMILY: Verdana, Helvetica;
	text-decoration:none;
	font-size: 12px;
}
</style>
<body bgcolor="#66aef2" link="#525E6E" alink="#525E6E" vlink="#525E6E">
<div align="center">
<?
//ini_set('DISPLAY_ERRORS','0');
//ini_set('error_reporting','E_ERROR');
$conexio = mysql_connect("localhost","cd4046","");
mysql_select_db ($db,$conexio) OR die ("No se puede conectar al Servidor SQL");
$img = $_GET['img'];
$sql = "SELECT * FROM lasfotos_com WHERE img='$img' ORDER BY id DESC";
$result = mysql_query($sql,$conexio);
?>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" width="100%" align="center" class="coment">
<th>.::Comentarios::.</th>
<?
while ($row=mysql_fetch_array($result)) {
		echo "<tr><td bgcolor=\"#afcbe7\"><b>Nick:</b>&nbsp;";
		echo $row['nick'];
		echo "</tr></td>";
		echo "<tr><td bgcolor=\"#bfcbe7\"><i>";
		echo $row['com'];
		echo "</i></tr></td>";
		}
	?>
	</table>
	<?
    mysql_free_result($result);
	mysql_close($conexio);
?>
<a href="comentarfoto.php?img=<?echo $img;?>">[Enviar Comentario]</a>
</div>
</body>
</html>