<?php
$host     = $_ENV['PGHOST']     ?? getenv('PGHOST')     ?? 'localhost';
$port     = $_ENV['PGPORT']     ?? getenv('PGPORT')     ?? '5432';
$dbname   = $_ENV['PGDATABASE'] ?? getenv('PGDATABASE') ?? 'railway';
$user     = $_ENV['PGUSER']     ?? getenv('PGUSER')     ?? 'postgres';
$password = $_ENV['PGPASSWORD'] ?? getenv('PGPASSWORD') ?? '';

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