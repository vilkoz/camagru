<?php
include_once 'database.php';
echo getenv("CLEARDB_DATABASE_URL");
echo "\n";
print_r($url);
echo "\n";
echo $DB_DSN;
echo "\n";
echo $DB_USER;
echo "\n";
echo $DB_PASS;
echo "\n";
echo "SERVER_NAME: ".$_SERVER['SERVER_NAME']."\n";
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
