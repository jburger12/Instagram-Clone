<?php
session_start();
if (empty($_POST[comm]) || empty($_GET[id_image])) {
	header("Location: gallery.php?page=$_GET[page]");
	exit;
}
include_once('escape.php');
$com = Escape::bdd($_POST[comm]);
if (preg_match('/\bscript\b/i', $com)) {
	header("Location: gallery.php?page=$_GET[page]&msg=Nice try!");
	exit;
} else {
	include_once "db.php";
	try {
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $db->prepare('INSERT INTO comment (login, id_image, comment) VALUES	(:login, :id_img, :comment)');
		$stmt->bindParam(':login', $_SESSION[login], PDO::PARAM_STR);
		$stmt->bindParam(':id_img', $_GET[id_image], PDO::PARAM_INT);
		$stmt->bindParam(':comment', $com, PDO::PARAM_STR);
		$stmt->execute();
		$stmt = $db->prepare('SELECT members.email FROM members INNER JOIN gallery ON members.login = gallery.login WHERE gallery.id = :id_img');
		$stmt->bindParam(':id_img', $_GET[id_image], PDO::PARAM_INT); 
		$stmt->execute();
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}

	$mail = $stmt->fetchColumn();
	$to = $mail;
	$subject = 'Camagru | Comment';
	$message = "

A new comment has been posted on your photo by $_SESSION[login]

Comment : $com 

 ";

	$headers = 'From:janadriaanburger@gmail.com' . "\r\n";
	mail($to, $subject, $message, $headers);
	header("Location: gallery.php?page=$_GET[page]");
}
?>
