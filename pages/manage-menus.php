<?php

session_start();

include '../config/database.php';

if(
!isset($_SESSION['user'])
){

header("Location: login.php");

exit;

}

if(

$_SESSION['user']['role_id']!=2

&&

$_SESSION['user']['role_id']!=3

){

die(
"Accès refusé"
);

}

$sql=
"SELECT *
FROM menus
ORDER BY id DESC";

$query=
$pdo->query(
$sql
);

$menus=
$query->fetchAll();

include
'../includes/header.php';

?>
<section class="container py-5">

<h1>

Gestion menus

</h1>

<a
href="add-menu.php"
class="btn btn-success mb-4"
>

Ajouter menu

</a>

<?php foreach(
$menus
as
$menu
){ ?>

<div class="card p-4 mb-4">

<h3>

<?= $menu['title']; ?>

</h3>

<p>

<?= $menu['description']; ?>

</p>

<a
href="/admin/edit_menu.php?id=<?= $menu['id']; ?>"
class="btn btn-warning"
>

Modifier

</a>

<a
href="/admin/delete_menu.php?id=<?= $menu['id']; ?>"
class="btn btn-danger"
>

Supprimer

</a>

</div>

<?php } ?>

</section>

<?php include '../includes/footer.php'; ?>