<?php

if(
session_status()
===
PHP_SESSION_NONE
){
session_start();
}

include '../config/database.php';

if(
!isset($_SESSION['user'])
){

header(
"Location: ../pages/login.php"
);

exit;

}

$user_id =
$_SESSION['user']['id'];

$sql =

"

SELECT

orders.*,

menus.title

FROM orders

JOIN menus

ON orders.menu_id=
menus.id

WHERE orders.user_id=
:user_id

ORDER BY orders.id DESC

";

$query =
$pdo->prepare(
$sql
);

$query->execute([

'user_id'=>
$user_id

]);

$orders =
$query->fetchAll(
PDO::FETCH_ASSOC
);

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

<h1 class="mb-4">

Mes commandes

</h1>

<?php if(!empty($orders)){ ?>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Menu</th>

<th>Prix</th>

<th>Statut</th>

<th>Date</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php foreach($orders as $order){ ?>

<tr>

<td>

<?= $order['id']; ?>

</td>

<td>

<?= $order['title']; ?>

</td>

<td>

<?= $order['total_price']; ?> €

</td>

<td>

<?php if(
$order['status']=='En attente'
){ ?>

<span class="badge bg-warning text-dark">

En attente

</span>

<?php }elseif(
$order['status']=='Validée'
){ ?>

<span class="badge bg-success">

Validée

</span>

<?php }elseif(
$order['status']=='Préparation'
){ ?>

<span class="badge bg-primary">

Préparation

</span>

<?php }elseif(
$order['status']=='Livrée'
){ ?>

<span class="badge bg-dark">

Livrée

</span>

<?php } ?>

</td>

<td>

<?= $order['created_at']; ?>

</td>

<td>

<a
href="/pages/cancel-order.php?id=<?= $order['id']; ?>"
class="btn btn-danger btn-sm"
>

Annuler

</a>

<br>

<a
href="../pages/edit_order.php?id=<?= $order['id']; ?>"
class="btn btn-warning btn-sm mb-1"
>

Modifier

</a>

<br>

<a
href="../pages/order-tracking.php?id=<?= $order['id']; ?>"
class="btn btn-info btn-sm mb-1"
>

Suivi

</a>

<?php if(
$order['status']
==
'Livrée'
){ ?>

<br>

<a
href="../pages/add_review.php?order_id=<?= $order['id']; ?>"
class="btn btn-warning btn-sm"
>

<i class="bi bi-star-fill"></i> Donner un avis

</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php }else{ ?>

<div class="alert alert-info">

Vous n'avez encore aucune commande.

</div>

<?php } ?>

</section>

<?php include '../includes/footer.php'; ?>