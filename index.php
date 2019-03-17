<?php

	if ($_GET[msg]) {echo "<script>alert(\"".htmlentities($_GET[msg])."\");window.location.href = \"index.php\";</script>";}
include_once 'header.php'
?>

		<h1 class="hometext">Capture and share</h1>
		<img class="easy" src="img/clogo1.png" />
		<div class="wrapper">
		<center>
		<ul class="menu_h">
			<li><a class="hey1" href="picture.php">Share your photo!</a></li>
			<li><a class="hey1" href="gallery.php">Explore!</a></li>
		</ul>
		</center>
		<div class="ban">
			<img src="img/cam.jpg" />
		</div>
		</div>
	</body>
</html>
