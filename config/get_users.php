<?php
include_once 'database.php';
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
$stmt = $pdo->prepare("SELECT * FROM `users`");
$stmt->exec();
print_r($stmt->fetchAll());
?>
