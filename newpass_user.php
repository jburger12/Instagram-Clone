<?php

include_once('header.php');

if ($_GET[msg]) {echo "<script>alert(\"".htmlentities($_GET[msg])."\");window.location.href = \"newpass_user.php\";</script>";}

if (empty($_POST[mdp]) || empty($_POST[remdp]) || empty($_POST[email])) {
	header("Location: newpass_user.php?msg=Please fill in all the blanks/n");
} else if (strlen($_POST[mdp]) < 8) {
	header("Location: newpass_user.php?msg=The password must contain at least 8 characters.\n");
} else if ($_POST[mdp] != $_POST[remdp]) {
	header("Location: newpass_user.php?msg=Passwords are not the same.\n");
}

try {
	include_once('db.php');
	include_once('escape.php');
	$email = Escape::bdd($_POST[email]);
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT COUNT(*) FROM members WHERE email = :email');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo "Error : ".$msg->getMessage();
	exit;
}
$passwd = hash('whirlpool', Escape::bdd($_POST[mdp]));
if ($stmt->fetchColumn()) {
	try {
		$stmt = $db->prepare("UPDATE members SET passwd = :passwd WHERE email = :email");
		$stmt->bindParam(':passwd', $passwd, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
	} catch (PDOException $msg) {
		echo "Error : ".$msg->getMessage();
		exit;
	}
	header("Location: index.php?msg=Your password has been changed.\n");
}

?>

			<form class='logform' action="newpass_user.php" method="post">
				<center>
				<label class='mytext' for='email'>Votre adresse email</label><br>
				<input class='mybar' type='email' name="email" placeholder="exemple@exemple.com"/><br/>
				<label class='mytext' for="mdp">Votre nouveau mot de passe</label><br>
				<input class='mybar' type="password" name="mdp" placeholder="enter your password" /><br/>
				<label class='mytext' for="remdp">Confirmez votre  mot de passe</label><br>
				<input class='mybar' type="password" name="remdp" placeholder="re-enter your password" /><br/>
				<input class='mybutton' type="submit" name="connection" /><br/>
				</center>
			</form>
		</div>
		<a class='mylink' href = "index.php">Return to home page</a>
	</body>
</html>
