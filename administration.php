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
	header('Location: index.php?msg=You n\ do not have access to this page');
}

?>
		<center>
		<ul class="menu_h">
			<li><a class="hey" href="del_user.php">Delete User</a></li>
			<li><a class="hey" href="login_user.php">Change Username</a></li>
			<li><a class="hey" href="mail_user.php">Change email</a></li>
		</ul>
		</center>
	</body>
</html>

