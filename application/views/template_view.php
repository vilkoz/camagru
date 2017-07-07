<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php if (isset($title)) {echo $title;}?></title>
	<?php if(!isset($_SESSION)) {session_start();}?>
  </head>
  <body>
	<header>
		<nav>
			<a href="/">Main</a> |
			<a href="/gallery">Gallery</a> |
<?php
if (isset($_SESSION['user']) && !empty($_SESSION['user']))
{
?>
			<a href="/add">New photo</a> |
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
	<footer>
		LC team @ 2017
	</footer>
  </body>
</html>
