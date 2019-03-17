<?php

if ($_GET[msg]) {echo "<script>alert(\"".htmlentities($_GET[msg])."\");window.location.href = \"forgot_user.php\";</script>";}

include_once('header.php');

?>

	<form class='logform' action="forgot.php" method="post">
		<center>
		<h3>Forgot password?<h3>
		<label class='mytext' for="email">Your email address</label><br>
		<input class='mybar' type="email" name="email" placeholder='enter your email address' /><br/>
		<input class='mybutton' type="submit" name="connection" /><br/>
		</center>
	</form>
</html>
