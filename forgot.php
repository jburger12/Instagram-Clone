<?php

include_once 'db.php';
include_once 'escape.php';

if (empty($_POST['email'])) {
	header("location: forgot_user.php?msg=Thank you, please fill in the email field.\n");
}

try {
	$email = Escape::bdd($_POST[email]);
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT * FROM members WHERE email = :email');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error :'.$msg->getMessage();
}
if ($stmt->fetchColumn()) {
	try {
		$newpass = rand(5, 4000000);
		$stmt = $db->prepare('UPDATE members SET passwd = :passwd WHERE email = :email');
		$stmt->bindParam(':passwd', $newpass, PDO::PARAM_STR);
		$stmt->bindParam('email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$to = $email;
		$subject = 'New Password | Camagru';
		$message = '

	Click this link to change your password :

	---------------------
		http://localhost:8080/Camagru/newpass_user.php?email='.$email.'&hash='.$newpass.'
	---------------------

	Enjoy!';
		$headers = 'From:janadriaanburger@gmail.com' . "\r\n";
		mail($to, $subject, $message, $headers);

	} catch (PDOException $msg) {
		echo "Error : ".$msg->getMessage();	
		exit;
	}
	header("Location: index.php?msg=Look at your email to change your password	!.\n");
} else {
	header("Location: index.php?msg=Error.\n");
}

?>
