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

if (!isset($_GET['id'])) {

    die("Menu introuvable");
}

$id = $_GET['id'];

$sql = "DELETE FROM menus WHERE id = :id";

$query = $pdo->prepare($sql);

$query->execute([
    'id' => $id
]);

header("Location: /admin/menus.php");
exit;