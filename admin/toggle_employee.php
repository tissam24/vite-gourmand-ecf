<?php

session_start();

include '../config/database.php';

$id = $_GET['id'];

$sql = "

UPDATE users

SET

is_active = NOT is_active

WHERE id = :id

";

$query = $pdo->prepare($sql);

$query->execute([

'id' => $id

]);

header(
"Location: employee.php"
);

exit;