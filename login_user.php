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

include_once('db.php');

try {
	$stmt = $db->prepare('UPDATE members SET login = :newlog WHERE login = :log');
	$stmt->bindParam(':newlog', $_POST[newlogin], PDO::PARAM_STR);
	$stmt->bindParam(':log', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
try {
	$stmt = $db->prepare('UPDATE gallery SET login = :newlog WHERE login = :log');
	$stmt->bindParam(':newlog', $_POST[newlogin], PDO::PARAM_STR);
	$stmt->bindParam(':log', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
try {
	$stmt = $db->prepare('UPDATE heart SET login = :newlog WHERE login = :log');
	$stmt->bindParam(':newlog', $_POST[newlogin], PDO::PARAM_STR);
	$stmt->bindParam(':log', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
try {
	$stmt = $db->prepare('UPDATE comment SET login = :newlog WHERE login = :log');
	$stmt->bindParam(':newlog', $_POST[newlogin], PDO::PARAM_STR);
	$stmt->bindParam(':log', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
?>

		<div class=nav>
			<form class='logform' action="login_user.php" method="post">
				<center>
				<label class='mytext' for="login">User login</label><br>
				<center><input class='mybar' type="text" name="login" placeholder="enter the login in question" /><br/>
				<label class='mytext' for="newlogin">New User login</label><br>
				<center><input class='mybar' type="text" name="newlogin" placeholder="enter the login in question" /><br/>
				<input class='mybutton' type="submit" name="send" /><br/>
				</center>
			</form>
		</div>
	</body>
</html>
