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

$sql =

"

SELECT *

FROM orders

WHERE user_id=?

ORDER BY id DESC

";

$query =
$pdo->prepare(
$sql
);

$query->execute([

$_SESSION['user']['id']

]);

$orders =
$query->fetchAll();

include '../includes/header.php';

?>

<section class="container py-5">

<h1>

Mes commandes

</h1>


<?php foreach($orders as $order){ ?>

<div class="card p-4 mb-4">

<h4>

Commande #<?= $order['id']; ?>

</h4>

<p>

Statut :

<?= $order['status']; ?>

</p>

<p>

Date :

<?= $order['event_date']; ?>

</p>

<p>

Prix :

<?= $order['total_price']; ?> €

</p>

<?php

$status =
trim(
strtolower(
$order['status']
)
);

if(

$status=="accepted"

||

$status=="preparation"

||

$status=="delivery"

||

$status=="completed"

||

$status=="livrée"

||

$status=="livree"

){

?>

<a
href="order-tracking.php?id=<?= $order['id']; ?>"
class="btn btn-primary"
>

Suivre

</a>

<?php } ?>

<div class="mt-3">

<a
href="cancel-order.php?id=<?= $order['id']; ?>"
class="btn btn-danger"
>

Annuler

</a>

<a
href="edit-order.php?id=<?= $order['id']; ?>"
class="btn btn-warning"
>

Modifier

</a>

<a
href="add_review.php?order_id=<?= $order['id']; ?>"
class="btn btn-warning"
>

⭐ Donner un avis

</a>

</div>

</div>

<?php } ?>

</section>

<?php include '../includes/footer.php'; ?>