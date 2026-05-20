<?php

$host = "localhost";
$port = "5432";
$dbname = "vite_gourmand";
$user = "tissam";
$password = "tissam24";

try {

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

} catch (PDOException $e) {

    die("Erreur connexion : " . $e->getMessage());
}