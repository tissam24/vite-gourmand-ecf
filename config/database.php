<?php
$host     = getenv('PGHOST')     ?: 'localhost';
$port     = getenv('PGPORT')     ?: '5432';
$dbname   = getenv('PGDATABASE') ?: 'vite_gourmand';
$user     = getenv('PGUSER')     ?: 'tissam';
$password = getenv('PGPASSWORD') ?: '';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}