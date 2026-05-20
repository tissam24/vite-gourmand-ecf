<?php

session_start();

include '../config/database.php';

if(
!isset($_SESSION['user'])
){

die(
"Connexion requise"
);

}

$id=
$_GET['id'];

$sql=

"

SELECT *

FROM orders

WHERE id=?

AND user_id=?

";

$query=
$pdo->prepare(
$sql
);

$query->execute([

$id,

$_SESSION['user']['id']

]);

$order=
$query->fetch();

if(!$order){

die(
"Commande introuvable"
);

}

if(
$_SERVER['REQUEST_METHOD']
===
'POST'
){

$sql=

"

UPDATE orders

SET

event_date=?,

comment=?

WHERE id=?

";

$query=
$pdo->prepare(
$sql
);

$query->execute([

$_POST['event_date'],

$_POST['comment'],

$id

]);

header(
"Location: ../user/dashboard.php"
);

exit;

}

include '../includes/header.php';

?>

<section class="container py-5">

<h2>

Modifier commande

</h2>

<form method="POST">

<label>

Date

</label>

<input

type="date"

name="event_date"

value="<?= $order['event_date'] ?>"

class="form-control mb-3"

>

<label>

Commentaire

</label>

<textarea

name="comment"

class="form-control mb-3"

><?= $order['comment'] ?></textarea>

<button
class="btn btn-success"
>

Enregistrer

</button>

</form>

</section>

<?php include '../includes/footer.php'; ?>