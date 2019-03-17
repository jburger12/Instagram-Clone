<?php

include_once 'db.php';

try {
	$DB = explode(';', $DB_DSN);
	$database = substr($DB[1], 7);
	$db = new PDO("$DB[0]", $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("CREATE DATABASE IF NOT EXISTS $database");
	echo "Database '$database' created successfully.<br>";
	$db->exec("use $database");
	$db->exec("CREATE TABLE IF NOT EXISTS members (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		email VARCHAR(255) NOT NULL,
		login VARCHAR(255) NOT NULL,
		passwd VARCHAR(255) NOT NULL,
		hash VARCHAR(255) NOT NULL,
		admin INT(9) DEFAULT 0,
		active INT(9) DEFAULT 0)");
	echo "Table 'members' created successfully.<br>";
	$db->exec("CREATE TABLE IF NOT EXISTS gallery (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255) NOT NULL,
		img VARCHAR(255) NOT NULL)");
	echo "Table 'gallery' created successfully.<br>";
	$db->exec("CREATE TABLE IF NOT EXISTS comment (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255) NOT NULL,
		id_image VARCHAR(255) NOT NULL,
		comment VARCHAR(255) NOT NULL)");
	echo "Table 'comment' created successfully.<br>";
	$db->exec("CREATE TABLE IF NOT EXISTS heart (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		login VARCHAR(255) NOT NULL,
		id_image VARCHAR(255) NOT NULL)");
	echo "Table 'heart' created successfully.<br><br><br>";
	$mail = 'janadriaanburger@gmail.com';
	$name = 'Adriaan';
	$pass = 'd3068f59aa0148fbe5b930dfb4f31db1311f4f0c2b652e3d0e6907f2fd28b140f2cc9ca802cede3bd5608fd1296328e4a7cc5314849ed0c9d09dcc3e80f557fd';
	$hash = 'ba2fd310dcaa8781a9a652a31baf3c68';
	$one = 1;
	$zero = 0;
	$stmt = $db->prepare('INSERT INTO members (email, login, passwd, hash, admin, active) VALUES (:email, :login, :passwd, :hash, :admin, :active)');
	$stmt->bindParam(':email', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':login', $name, PDO::PARAM_STR);
	$stmt->bindParam(':passwd', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
	$stmt->bindParam(':admin', $one, PDO::PARAM_STR);
	$stmt->bindParam(':active', $one, PDO::PARAM_STR);
	$stmt->execute();	
	echo "Table members filled.<br>";
	$t = 'Adriaan';
	$img = 'image/1.jpeg';
	$stmt = $db->prepare('INSERT INTO gallery (login, img) VALUES (:login, :img)');
	$stmt->bindParam(':login', $t, PDO::PARAM_STR);
	$stmt->bindParam(':img', $img, PDO::PARAM_STR);
	$stmt->execute();
	$img = 'image/2.jpeg';
	$stmt = $db->prepare('INSERT INTO gallery (login, img) VALUES (:login, :img)');
	$stmt->bindParam(':login', $t, PDO::PARAM_STR);
	$stmt->bindParam(':img', $img, PDO::PARAM_STR);
	$stmt->execute();
	$img = 'image/3.jpeg';
	$stmt = $db->prepare('INSERT INTO gallery (login, img) VALUES (:login, :img)');
	$stmt->bindParam(':login', $t, PDO::PARAM_STR);
	$stmt->bindParam(':img', $img, PDO::PARAM_STR);
	$stmt->execute();

	echo "Table gallery filled.<br>";
} catch (PDOException $e) {
	echo $sql.'<br>'.$e->getMessage();
}
$db = null;
?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title>Camagru</title>
  </head>
  <body>
	<form action="index.php" class="inline">
		<button autofocus="autofocus" tabindex="1">Index</button>
	</form>
  </body>
</html>
