<?php

$host =
getenv('DB_HOST') ?: 'localhost';

$port =
getenv('DB_PORT') ?: '5432';

$dbname =
getenv('DB_NAME') ?: 'vite_gourmand';

$user =
getenv('DB_USER') ?: 'tissam';

$password =
getenv('DB_PASSWORD') ?: 'password';

try{

$pdo=
new PDO(
"pgsql:host=$host;port=$port;dbname=$dbname",
$user,
$password
);

$pdo->setAttribute(
PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION
);

}

catch(PDOException $e){

$pdo=null;

}