<!-- BEGIN LOGGEDBLOCK -->
<font size="-1" color="#888888">
{STATUS} - {USER} level {LEVEL} keys: {KEYS} 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?logout=1">Logout {USER}</a><br>
</font>
<!-- END LOGGEDBLOCK -->
<!-- BEGIN NOTLOGGEDBLOCK -->
<font size="-2" color="#888888">
<!--{STATUS} - {USER} level {LEVEL} keys: {KEYS} <br>-->
<form method="POST">
<input type="text" name="username" />
<input type="password" name="password" />
<input type="hidden" name="bifLogin" value="1" />
<input type="submit" value="Login" />
&nbsp;&nbsp;&nbsp;<a href="meolvide.php">Me olvidé la clave</a>
</form>
</font>
<!-- END NOTLOGGEDBLOCK -->
