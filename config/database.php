<?php

$host =
$_ENV['DB_HOST']
?? getenv('DB_HOST')
?? 'localhost';

$port =
$_ENV['DB_PORT']
?? getenv('DB_PORT')
?? '5432';

$dbname =
$_ENV['DB_NAME']
?? getenv('DB_NAME')
?? 'vite_gourmand';

$user =
$_ENV['DB_USER']
?? getenv('DB_USER')
?? 'tissam';

$password =
$_ENV['DB_PASSWORD']
?? getenv('DB_PASSWORD')
?? 'password';

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

}catch(PDOException $e){

$pdo = null;

}