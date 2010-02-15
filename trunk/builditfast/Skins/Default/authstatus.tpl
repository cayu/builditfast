<!-- BEGIN LOGGEDBLOCK -->
<font size="-1" color="#888888">
{STATUS} - {USER} level {LEVEL} keys: {KEYS} 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="index.php?logout=1">Logout {USER}</a><br>
</font>
<!-- END LOGGEDBLOCK -->
<!-- BEGIN NOTLOGGEDBLOCK -->
<!--{STATUS} - {USER} level {LEVEL} keys: {KEYS} <br>-->
<form method="POST">
<input type="text" name="username" style="FONT-SIZE:8px;"/>
<input type="password" name="password" style="FONT-SIZE:8px;"/>
<input type="hidden" name="bifLogin" value="1" />
<input type="submit" value="Login" style="FONT-SIZE:8px;" />
</form>
<!-- END NOTLOGGEDBLOCK -->
