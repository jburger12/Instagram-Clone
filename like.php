<?php
session_start();
include_once 'db.php';
if (empty($_GET[id_image])) {
	header("Location: gallery.php?Please fill in the blanks.\n");
	exit;
}
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT COUNT(*) FROM heart WHERE login = :log AND id_image = :id_img');
	$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
	$stmt->bindParam(':id_img', $_GET[id_image], PDO::PARAM_INT);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
if ($stmt->fetchColumn()) {
	try {
		$stmt = $db->prepare('DELETE FROM heart WHERE login = :log AND id_image = :id_img');	
		$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
		$stmt->bindParam(':id_img', $_GET[id_image], PDO::PARAM_INT);
		$stmt->execute();
		header("Location: gallery.php?page=$_GET[page]");
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
} else {
	try {
		$stmt = $db->prepare('INSERT INTO heart (login, id_image) VALUES (:log, :id_img)');
		$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
		$stmt->bindParam(':id_img', $_GET[id_image], PDO::PARAM_INT);
		$stmt->execute();
		header("Location: gallery.php?page=$_GET[page]");
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
}
