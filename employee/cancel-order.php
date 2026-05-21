<?php

session_start();

include '../config/database.php';

if(
$_SESSION['user']['role_id']
!=2
){

die(
"Accès refusé"
);

}

$id =
$_GET['id'];

if(
$_SERVER['REQUEST_METHOD']
==="POST"
){

$sql=
"
UPDATE orders

SET

status='cancelled',

cancel_method=?,

cancel_reason=?

WHERE id=?
";

$query=
$pdo->prepare(
$sql
);

$query->execute([

$_POST['method'],

$_POST['reason'],

$id

]);

header(
"Location: manage-orders.php"
);

exit;

}

include
'../includes/header.php';

?>
<section class="container py-5">

<div class="card p-5">

<h2>

Annuler commande

</h2>

<form method="POST">

<div class="mb-3">

<label>

Mode de contact

</label>

<select
name="method"
class="form-select"
required
>

<option>

GSM

</option>

<option>

Mail

</option>

</select>

</div>

<div class="mb-3">

<label>

Motif

</label>

<textarea
name="reason"
class="form-control"
rows="4"
required
></textarea>

</div>

<div class="alert alert-warning">

<i class="bi bi-exclamation-triangle-fill"></i> Le client doit avoir été contacté avant validation.

</div>

<button
class="btn btn-danger"
>

Annuler

</button>

</form>

</div>

</section>

<?php include '../includes/footer.php'; ?>