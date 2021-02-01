<?php

$config = include('../config/db.php');

$host       = $config['host'];
$username   = $config['username'];
$password   = $config['password'];
$database   = $config['database'];
$charset    = $config['charset'];


$dsn = "mysql:host=$host;dbname=$database;charset=$charset";

return new PDO($dsn, $username, $password);