<?php 

if ($_GET[msg]) {echo "<script>alert(\"".htmlentities($_GET[msg])."\");window.location.href = \"create_user.php\";</script>";}

include_once('header.php'); 

echo '<h4>Please fill in all the fields, an email will be sent shortly to activate your account </h4>';

?>

<div class=nav>
			<form class='logform' action="create.php" method="post">
				<center>
				<label class='mytext' for="email">Your email address</label><br>
				<input class='mybar' type="email" name="email" placeholder="example@example.com"/><br/>
				<label class='mytext' for="login">Your login</label><br>
				<center><input class='mybar' type="text" name="login" placeholder="enter your login" /><br/>
				<label class='mytext' for="mdp">Your password</label><br>
				<input class='mybar' type="password" name="mdp" placeholder="enter your password" /><br/>
				<label class='mytext' for="remdp">Confirm your password</label><br>
				<input class='mybar' type="password" name="remdp" placeholder="re-enter your password" /><br/>
				<input class='mybutton' type="submit" name="connection" /><br/>
				</center>
			</form>
		</div>
		<a class='mylink' href = "index.php">Reurn to the home page</a>
	</body>
</html>
