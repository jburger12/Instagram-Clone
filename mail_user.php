<?php

session_start();

include_once('db.php');
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT admin FROM members WHERE login = :log');
	$stmt->bindParam(':log', $_SESSION['login'], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
$admin = $stmt->fetchColumn();

if ($admin == 1) {
	include_once('header.php');
} else {
	header('Location: index.php?msg=You n\'do not have access to this page');
}

include_once('escape.php');
try {
	$email = Escape::bdd($_POST[email]);
	$nemail = Escape::bdd($_POST[newmail]);
	$stmt = $db->prepare('UPDATE members SET email = :newmail WHERE email = :email');
	$stmt->bindParam(':newmail', $_POST[newmail], PDO::PARAM_STR);
	$stmt->bindParam(':email', $_POST[email], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}

?>

<div class=nav>
			<form class='logform' action="mail_user.php" method="post">
				<center>
				<label class='mytext' for="email">Email address</label><br>
				<input class='mybar' type="email" name="email" placeholder="example@example.com"/><br/>
				<label class='mytext' for="newmail">New email address</label><br>
				<input class='mybar' type="email" name="newmail" placeholder="example@example.com"/><br/>
				<input class='mybutton' type="submit" name="connection" /><br/>
				</center>
			</form>
		</div>
		<a class='mylink' href = "index.php">Return to home page</a>
	</body>
</html>
