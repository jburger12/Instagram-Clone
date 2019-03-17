<?php
include_once 'escape.php';

if ($_GET[msg]) {echo "<script>alert(\"".htmlentities($_GET[msg])."\");window.location.href = \"gallery.php\";</script>";}
session_start();

if ($_SESSION[login]) {
	if (!$_GET[page]) {
		header('Location: gallery.php?page=1');
	}
	include_once 'header.php';
} else {
	header('Location: index.php?msg=You must login to access the page');
}
$page = Escape::bdd(intval($_GET[page]));
if (strlen($page) > 10) {
	header('Location: index.php?msg=The page n\'does not exist');	
	exit;
}
include_once 'db.php';

$nb = ($page - 1) * 10;
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT * FROM gallery ORDER BY id DESC LIMIT 10 OFFSET :nb');
	$stmt->bindParam(':nb', $nb, PDO::PARAM_INT);
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}

$sql = $stmt->fetchAll();
if (!$sql) {
	if ($page > 1 AND $page < 3) {
		$preview = $page - 1;
		header("Location: gallery.php?page=$prev");
		exit;
	} else {
		echo '<h4>The gallery is empty, be the first to post a photo !</h4>';
	}
}
echo "<center><ul class='pagination1'>";
try {
	$stmt = $db->prepare("SELECT COUNT(*) from gallery");
	$stmt->execute();
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	exit;
}
$nb = ($stmt->fetchColumn() - 1) / 10 + 1;
$previous = $page - 1;
if ($previous > 0) {
	echo "<li><a href='?page=$previous'>&laquo;</a></li>";
}
for ($i = 1; $i <= $nb; ++$i) {
	echo "<li><a  href='?page=$i'>$i</a></li>";
}
$next = $page + 1;
if ($next < $nb) {
	echo "<li><a href='?page=$next'>&raquo;</a></li>";
}
echo "</ul></center>";

echo '<br/>';
echo "<div>";
foreach ($sql as $key => $value) {
	echo "<div class='boximg'>";
	try {
		$stmt = $db->prepare("SELECT COUNT(*) FROM heart WHERE id_image = :id_img");
		$stmt->bindParam(':id_img', $value[id], PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
	$heart = $stmt->fetchColumn();
	try {
		$stmt = $db->prepare("SELECT admin from members WHERE login = :log");
		$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
		$stmt->execute();
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
	$admin = $stmt->fetchColumn();
	if ($value[login] == $_SESSION[login] || $admin == 1) {
		echo "<a href='remove.php?img=$value[id]&page=$page'><img src='images/trash.png' width='30' style='position:absolute'></a>";
	}
	echo "<img src='$value[img]' style='width:400px'><br/>
		Posted by : <i>$value[login]<br/></i>
		heart : $heart";
		try {
			$stmt = $db->prepare('SELECT COUNT(*) FROM heart WHERE login = :log AND id_image = :id_img');
			$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
			$stmt->bindParam(':id_img', $value[id], PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $msg) {
			echo 'Error: '.$msg->getMessage();
			exit;
		} if ($stmt->fetchColumn()) {	
			echo "<a href='like.php?id_image=$value[id]&page=$page' style='float:right;margin-top:-20px'>
					<img src='images/dislike.png' width='30' height='30' style='margin-top:10px'>
				</a>";
		} else {
			echo "<a href='like.php?id_image=$value[id]&page=$page' style='float:right;margin-top:-20px'>
					<img src='images/Like.png' width='30' height='30' style='margin-top:10px'>
				</a>";
		}
	echo "<form class='com' action='comment.php?id_image=$value[id]&page=$page' method='post'><br/>
			<input class='comform' style='width:100%' type='text' placeholder='Enter your comment' name='comm' required>
			<input type='submit' class='button' name='Valider'/>
		</form>"; 

	try {
		$stmt = $db->prepare("SELECT * FROM comment WHERE id_image = :id_img");
		$stmt->bindParam(':id_img', $value[id], PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $msg) {
		echo 'Error: '.$msg->getMessage();
		exit;
	}
	$sql = $stmt->fetchAll();
	if ($sql) {
		echo "<div class='comment'>";
		foreach ($sql as $key => $var) {
			echo "by <i>$var[login]</i> : $var[comment] <hr>";
		}
		echo '</div>';
	}
	echo '</div>';
}
echo "</div>";

?>

	</body>
</html>
