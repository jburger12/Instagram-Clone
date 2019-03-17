<?php

include_once 'db.php';
include_once 'escape.php';

if (empty($_POST[email]) || empty($_POST[login]) || empty($_POST[mdp])) {
	header("location: create_user.php?msg=Please fill in all the fields.\n");
	exit;
} else if (strlen($_POST[mdp]) < 8) {
	header("location: create_user.php?msg=The password must contain at least 8 characters.\n");
	exit;
} else if ($_POST[mdp] != $_POST[remdp]) {
	header("location: create_user.php?msg=Passwords are not the same.\n");
	exit;
}

$log = Escape::bdd($_POST[login]);
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT COUNT(*) FROM members WHERE login = :login');
	$stmt->bindParam(':login', $log, PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $mess) {
	echo 'Error: '.$mess->getMessage();
	exit;
}
if ($stmt->fetchColumn()) {
	header("Location: create_user.php?msg=Login already taken.\n");
	exit;
}
$passwd = hash('whirlpool', Escape::bdd($_POST['mdp']));
$hash = md5( rand(0,1000) );
$email = Escape::bdd($_POST[email]);
try {
	$stmt = $db->prepare('INSERT INTO members (email, login, passwd, hash) VALUES (:email, :login, :passwd, :hash)');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':login', $log, PDO::PARAM_STR);
	$stmt->bindParam(':passwd', $passwd, PDO::PARAM_STR);
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $mess) {
	echo 'Error: '.$mess->getMessage();
	exit;
}

$to      = $email;
$subject = 'Signup | Verification';
$message = '

	Thanks for signing up!
	Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

	------------------------
	Username: '.$log.'
	------------------------

	Please click this link to activate your account:
	http://localhost:8080/Camagru/verify.php?email='.$email.'&hash='.$hash.'

	';

$headers = 'From:janadriaanburger@gmail.com' . "\r\n";
mail($to, $subject, $message, $headers);
$_SESSION['login']=$log;
header("Location: index.php?msg=Your account was created. Please consult your email to activate your account.\n");

?>
