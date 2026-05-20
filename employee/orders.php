<?php

include '../config/database.php';

include '../includes/header.php';

if(
isset($_POST['order_id'])
&&
isset($_POST['status'])
){

if(
$_POST['status']
===
'Annulée'
){

if(
empty($_POST['contact_method'])
||
empty($_POST['cancel_reason'])
){

die(
'Contact et motif obligatoires avant annulation'
);

}

$sql=

"

UPDATE orders

SET

status=?,

contact_method=?,

cancel_reason=?

WHERE id=?

";

$query=
$pdo->prepare(
$sql
);

$query->execute([

$_POST['status'],

$_POST['contact_method'],

$_POST['cancel_reason'],

$_POST['order_id']

]);

}

else{

$sql=

"

UPDATE orders

SET status=?

WHERE id=?

";

$query=
$pdo->prepare(
$sql
);

$query->execute([

$_POST['status'],

$_POST['order_id']

]);

}

}

$status=
$_GET['status']
?? '';

$search=
$_GET['search']
?? '';

$sql=

"

SELECT

orders.*,

users.firstname,

users.lastname

FROM orders

LEFT JOIN users

ON users.id=
orders.user_id

WHERE TRUE

";

$params=[];

if(
$status!=''
){

$sql.=
"
AND orders.status=?
";

$params[]=
$status;

}

if(
$search!=''
){

$sql.=

"

AND(

users.firstname LIKE ?

OR

users.lastname LIKE ?

)

";

$params[]=
"%$search%";

$params[]=
"%$search%";

}

$sql.=

"

ORDER BY orders.id DESC

";

$query=
$pdo->prepare(
$sql
);

$query->execute(
$params
);

$orders=
$query->fetchAll();

?>

<section class="container-fluid py-5 px-5">

<h1 class="mb-5">

Gestion des commandes

</h1>

<form
method="GET"
class="row g-3 mb-4"
>

<div class="col-md-4">

<label>

Filtrer par statut

</label>

<select
name="status"
class="form-select"
>

<option
value=""
<?= $status=='' ? 'selected' : '' ?>
>

Tous

</option>

<option
value="En attente"
<?= $status=='En attente' ? 'selected' : '' ?>
>

En attente

</option>

<option
value="En préparation"
<?= $status=='En préparation' ? 'selected' : '' ?>
>

En préparation

</option>

<option
value="Validée"
<?= $status=='Validée' ? 'selected' : '' ?>
>

Validée

</option>

<option
value="Livrée"
<?= $status=='Livrée' ? 'selected' : '' ?>
>

Livrée

</option>

<option
value="Annulée"
<?= $status=='Annulée' ? 'selected' : '' ?>
>

Annulée

</option>

</select>

</div>

<div class="col-md-5">

<label>

Rechercher client

</label>

<input
type="text"
name="search"
class="form-control"
placeholder="Nom du client"
value="<?= $search ?>"
>

</div>

<div class="col-md-3">

<button
class="btn btn-warning w-100"
>

Appliquer filtre

</button>

</div>

</form>

<div class="card shadow">

<div class="card-body">

<table class="table">

<thead>

<tr>

<th>ID</th>

<th>Client</th>

<th>Statut</th>

<th>Modifier</th>

</tr>

</thead>

<tbody>

<?php foreach($orders as $order){ ?>

<tr>

<td>

<?= $order['id'] ?>

</td>

<td>

<?= $order['firstname'] ?>

<?= $order['lastname'] ?>

</td>

<td>

<?= $order['status'] ?>

</td>

<td>

<form method="POST">

<input
type="hidden"
name="order_id"
value="<?= $order['id'] ?>"
>

<label>

Statut

</label>

<select
name="status"
class="form-select mb-3"
required
>

<option value="En attente">

En attente

</option>

<option value="En préparation">

En préparation

</option>

<option value="Validée">

Validée

</option>

<option value="Livrée">

Livrée

</option>

<option value="Annulée">

Annulée

</option>

</select>

<label>

Mode contact

</label>

<select
name="contact_method"
class="form-select mb-3"
>

<option value="">

Choisir

</option>

<option value="GSM">

GSM

</option>

<option value="Mail">

Mail

</option>

</select>

<label>

Motif annulation

</label>

<textarea

name="cancel_reason"

class="form-control mb-3"

rows="2"

placeholder="Ex : client indisponible"

></textarea>

<button

class="btn btn-success"

>

Mettre à jour

</button>

</form>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</section>

<?php include '../includes/footer.php'; ?>