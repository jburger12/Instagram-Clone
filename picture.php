<?php
session_start();
if ($_SESSION[login]) {
	include_once 'header.php';
} else {
	header('Location: index.php?msg=Vous devez vous connecter pour acceder a cette page');
}
?>

<script src="webcam.js" charset="utf-8"></script>
    <article class="main">
    <div class="videobox">
	<video id="video"></video>
	<img id="image" height="640px" width="480px" style="display: none;"/>
	<div id="canvasvideo"></div>
	    <br/>
      <button class="button" id="snap" onclick="javascript:Shot()">Take picture</button>
      </br>
      <br/>
    <input type='file' accept="image/*" onchange="readURL(this);" />
    <br/>
    <img id="image" height="640px" width="480px" style="display: none;"/>
  </div>
  </article>
	<form id="img_filter">
	<label for="logo42" class="logo42">
	  <input type="radio" name="img_filter" value="images/filters/42.png" id="logo42" onchange="myimage('logo42')">
	  <img class="img" src="images/filters/42.png" height="128" width="128">
	</label>
	<label for="risitas" class="risitas">
	  <input type="radio" name="img_filter" value="images/filters/risitas.png" id="risitas" onchange="myimage('risitas')">
	  <img class="img" src="images/filters/risitas.png" height="128" width="128">
	</label>
	<label for="doge" class="doge">
	  <input type="radio" name="img_filter" value="images/filters/doge.png" id="doge" onchange="myimage('doge')">
	  <img class="img" src="images/filters/doge.png" height="128" width="128">
	</label>
	<label for="thug" class="thug">
	  <input type="radio" name="img_filter" value="images/filters/thug.png" id="thug" onchange="myimage('thug')">
	  <img class="img" src="images/filters/thug.png" height="128" width="128">
	</label>
	<br/>
	<label for="saltbae" class="saltbae">
	  <input type="radio" name="img_filter" value="images/filters/saltbae.png" id="saltbae" onchange="myimage('saltbae')">
	  <img class="img" src="images/filters/saltbae.png" height="128" width="128">
	</label>
	<label for="trollface" class="trollface">
	  <input type="radio" name="img_filter" value="images/filters/trollface.png" id="trollface" onchange="myimage('trollface')">
	  <img class="img" src="images/filters/trollface.png" height="128" width="128">
	</label>
      </form>

  <aside class="aside2">
    <div class="videobox">
    <h3>Overview</h3>
    <div id="canvas"></div>
    <form method='post' accept-charset='utf-8' name='form'>
      <input name='img' id='img' type='hidden'/>
      <input name='user' id='user' type='hidden' value='<?=$_SESSION[login];?>'/>
    </form>
  </div>
  </aside>
<a class='mylink' href = "index.php">Return to home page</a>
	</body>
</html>
