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

if(!$order){

die(
"Commande introuvable"
);

}

if(
$_SERVER['REQUEST_METHOD']
==="POST"
){

$sql =
"UPDATE orders
SET

phone=?,
address=?,
event_date=?,
people=?,
comment=?

WHERE id=?";

$query =
$pdo->prepare($sql);

$query->execute([

$_POST['phone'],

$_POST['address'],

$_POST['event_date'],

$_POST['people'],

$_POST['comment'],

$id

]);

header(
"Location: my-orders.php"
);

exit;

}

include
'../includes/header.php';

?>
<section class="container py-5">

<div class="card p-5">

<h2>

Modifier commande

</h2>

<form method="POST">

<div class="mb-3">

<label>

Téléphone

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= $order['phone']; ?>"

>

</div>

<div class="mb-3">

<label>

Adresse

</label>

<textarea
name="address"
class="form-control"
><?= $order['address']; ?></textarea>

</div>

<div class="mb-3">

<label>

Date

</label>

<input
type="date"
name="event_date"
class="form-control"
value="<?= $order['event_date']; ?>"
>

</div>

<div class="mb-3">

<label>

Nombre personnes

</label>

<input
type="number"
name="people"
class="form-control"
value="<?= $order['people']; ?>"
>

</div>

<div class="mb-3">

<label>

Commentaire

</label>

<textarea
name="comment"
class="form-control"
><?= $order['comment']; ?></textarea>

</div>

<div class="alert alert-warning">

⚠️ Le menu ne peut pas être modifié.

</div>

<button
class="btn btn-warning w-100"
>

Enregistrer

</button>

</form>

</div>

</section>

<?php include '../includes/footer.php'; ?>