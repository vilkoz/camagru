<?php
include_once 'database.php';
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$sql = file_get_contents('camagru.sql');
$pdo->exec($sql);
 ?>
