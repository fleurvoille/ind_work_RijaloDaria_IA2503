<?php

$host = '127.0.0.1';
$port = '5432';
$dbname = 'filmwatch';
$username = 'fleurvoille';
$password = 'abcabc';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch (PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}
