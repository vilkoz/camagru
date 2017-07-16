<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php if (isset($title)) {echo $title;}?></title>
	<?php if(!isset($_SESSION)) {session_start();}?>
	<link rel="stylesheet" type="text/css" href="/css/style.css">
  </head>
  <body>
	<div id="menu" class="show">
		<div class="menu-container">
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</div>
	</div>
	<div class="page-wrap">
	<header>
		<nav>
<?php
if (!isset($_SESSION['user']) || empty($_SESSION['user']))
{
?>
			<a href="/">Main</a>
<?php
}
?>
			<a href="/gallery">Gallery</a>
<?php
if (isset($_SESSION['user']) && !empty($_SESSION['user']))
{
?>
			<a href="/add">New photo</a>
			<a href="/logout">Log out</a>
<?php
}
else
{
?>
			<a href="/login">Login</a>
<?php
}
?>
		</nav>
	</header>
	<?php include 'application/views/'.$content_view; ?>
	</div>
<script>
var toggle_menu = function() {
	document.querySelector('header').classList.toggle('show');
	document.querySelector('#menu').classList.toggle('show');

	if ((cover = document.querySelector('.perview-cover')) != null) {
		cover.parentElement.removeChild(cover);
	}
	else {
		div = document.createElement('div');
		div.classList.add('perview-cover');
		div.addEventListener('click', toggle_menu);
		document.querySelector('.page-wrap').appendChild(div);
	}
}
document.getElementById("menu").addEventListener('click', function() {
	toggle_menu();
	console.log("gopa");
});
</script>
	<footer>
		<p>LC team @ 2017</p>
	</footer>
  </body>
</html>
