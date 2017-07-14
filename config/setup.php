<?php
include_once 'database.php';
try
{
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
}
catch (PDOException $e)
{
	echo "Error ".$e->message;
	$pdo = new PDO('mysql:host=127.0.0.1', $DB_USER, $DB_PASS);
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = file_get_contents('camagru.sql');
try 
{
	$pdo->exec($sql);
}
catch (PDOException $e)
{
	print_r($e);
}
 ?>
