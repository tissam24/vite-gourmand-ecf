<?php

session_start();

include '../config/database.php';

if(
!isset($_SESSION['user'])
){

header(
"Location: login.php"
);

exit;

}

if(
!isset($_GET['id'])
){

die(
"Commande introuvable"
);

}

$order_id =
(int)
$_GET['id'];

$sql =

"

SELECT *

FROM orders

WHERE

id=?

AND

user_id=?

";

$query =
$pdo->prepare(
$sql
);

$query->execute([

$order_id,

$_SESSION['user']['id']

]);

$order =
$query->fetch();

if(
!$order
){

die(
"Commande introuvable"
);

}

if(
$order['status']
==
'Livrée'
){

die(
"Impossible d'annuler une commande livrée"
);

}

$sql =

"

UPDATE orders

SET status='Annulée'

WHERE id=?

";

$query =
$pdo->prepare(
$sql
);

$query->execute([

$order_id

]);

header(
"Location: ../user/dashboard.php"
);

exit;