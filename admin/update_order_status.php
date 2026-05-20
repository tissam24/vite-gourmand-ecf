<?php

session_start();

include '../config/database.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../pages/login.php");
    exit;
}

if(
$_SESSION['user']['role_id']
!=3
){

die(
"Accès refusé"
);

}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    die("Requête invalide");
}

$order_id = $_POST['order_id'];

$status = $_POST['status'];

$sql = "
UPDATE orders
SET status = :status
WHERE id = :id
";

$query = $pdo->prepare($sql);

$query->execute([

    'status' => $status,
    'id' => $order_id

]);

header("Location: /admin/dashboard.php");
exit;