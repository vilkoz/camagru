<?php
include_once 'database.php';
echo getenv("CLEARDB_DATABASE_URL");
print_r($url);
echo $DB_DSN;
echo $DB_USER;
echo $DB_PASS;
try
{
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
}
catch (PDOException $e)
{
	echo print_r($e);
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
