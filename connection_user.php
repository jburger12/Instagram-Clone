<?php

if ($_GET[msg]) {echo "<script>alert(\"".htmlentities($_GET[msg])."\");window.location.href = \"connection_user.php\";</script>";}

include_once('header.php');

?>

	<form class='logform' action="connection.php" method="post">
		<center>
		<label class='mytext' for="login">Login</label><br>
		<input class='mybar' type="text" name="login" placeholder='enter your username' /><br/>
		<label class='mytext' for="passwd">Password</label><br>
		<input class='mybar' type="password" name="passwd" placeholder='enter your password' /><br/>
		<a href='forgot_user.php'>Forgot your password</a><br/>
		<input class='mybutton' type="submit" name="connection" /><br/>
		</center>
	</form>
</html>
