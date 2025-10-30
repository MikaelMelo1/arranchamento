<?php

require_once __DIR__.'/envloader.php';

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];
$nr_dias = $_ENV['NR_DIAS'];
$lock = $_ENV['LOCK'];
?>

