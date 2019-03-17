<?php
session_start();
include_once 'db.php';
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT admin FROM members WHERE login = :log');
	$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
$admin = $stmt->fetchColumn();
if ($admin == 1) {
	try {
		$stmt = $db->prepare('DELETE FROM gallery WHERE id = :id_img');
		$stmt->bindParam(':id_img', $_GET[img], PDO::PARAM_INT);
		$stmt->execute();
		header("Location: gallery.php?page=$_GET[page]");
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
}
else {
	try {
		$stmt = $db->prepare('DELETE FROM gallery WHERE login = :log AND id = :id_img');
		$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
		$stmt->bindParam(':id_img', $_GET[img], PDO::PARAM_INT);
		$stmt->execute();
		header("Location: gallery.php?page=$_GET[page]");
		exit;
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
}
?>
