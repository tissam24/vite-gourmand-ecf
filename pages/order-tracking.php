<?php

session_start();

include '../config/database.php';

$id =
$_GET['id'];

$sql =
"SELECT *
FROM orders
WHERE id=?";

$query =
$pdo->prepare($sql);

$query->execute([$id]);

$order =
$query->fetch();

include '../includes/header.php';

?>

<section class="container py-5">

<div class="card p-5">

<h2>

Suivi commande

</h2>

<hr>

<p>

<i class="bi bi-check-circle-fill"></i> Commande créée

</p>

<p>

<?= $order['created_at']; ?>

</p>

<?php if(

$order['status']=="accepted"

||

$order['status']=="preparation"

||

$order['status']=="delivery"

||

$order['status']=="completed"

){ ?>

<hr>

<p>

<i class="bi bi-check-circle-fill"></i> Acceptée

</p>

<p>

<?= $order['updated_at']; ?>

</p>

<?php } ?>

<?php if(

$order['status']=="preparation"

||

$order['status']=="delivery"

||

$order['status']=="completed"

){ ?>

<hr>

<p>

<i class="bi bi-egg-fried"></i> Préparation

</p>

<?php } ?>

<?php if(

$order['status']=="delivery"

||

$order['status']=="completed"

){ ?>

<hr>

<p>

<i class="bi bi-truck"></i> Livraison

</p>

<?php } ?>

<?php if(

$order['status']=="completed"

){ ?>

<hr>

<p>

<i class="bi bi-flag-fill"></i> Terminée

</p>

<?php } ?>

</div>

</section>

<?php include '../includes/footer.php'; ?>