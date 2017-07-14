<?php

if ($_SERVER['SERVER_NAME'] == 'camagru-vilkoz.herokuapp.com')
{
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url['host'];
	$user = $url['user'];
	$pass = $url['pass'];
	$db = substr($url['path'], 1);
	$DB_DSN = 'mysql:dbname=' . $db .';host=' . $host;
	$DB_USER = $user;
	$DB_PASS = $pass;
}
else
{
	$DB_DSN = 'mysql:dbname=camagru;host=localhost';
	$DB_USER = 'vilkoz';
	/* $DB_PASS = 'goldfish12'; */
	// $DB_PASS = 'suck my fuck';
	$DB_PASS = '';
}
 ?>
