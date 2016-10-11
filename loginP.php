<?php
session_start();

?>
<html>

<body>

<form action="login_client.php" method="GET">
<fieldset><legend>Enter your information </legend>

<label for = "user"> User name </label>
	<input type=text name="UserName"
		 autofocus=on placeholder="User" autocomplete="off"><br><br>

<label for = "password"> Password</label>
	<input type=password name="Password" id="password"
		autofocus=on placeholder="Password" autocomplete="off" > &nbsp &nbsp
<input type =checkbox id="checkbox" onclick="See()">Show password<br><br>

<input type="hidden" name="user_token" value=""> 
<input type=submit name="submit" ><br><br>
</fieldset>

</form>


</html>
