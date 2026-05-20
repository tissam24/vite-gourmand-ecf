<?php

session_start();

include '../config/database.php';

if(
!in_array(
$_SESSION['user']['role_id'],
[2,3]
)
){

die(
"Accès refusé"
);

}

if(
isset($_POST['save'])
){

foreach(
$_POST['hours']
as
$id=>$value
){

$sql=
"
UPDATE
opening_hours

SET

hours=?

WHERE id=?
";

$query=
$pdo->prepare(
$sql
);

$query->execute([

$value,

$id

]);

}

}

$sql=
"
SELECT *
FROM opening_hours
";

$hours=
$pdo
->query(
$sql
)
->fetchAll();

include
'../includes/header.php';

?>
<section class="container py-5">

<h1>

Modifier horaires

</h1>

<form method="POST">

<?php foreach(
$hours
as
$hour
){ ?>

<div class="mb-3">

<label>

<?= $hour['day_name']; ?>

</label>

<input
type="text"
name="hours[<?= $hour['id']; ?>]"
value="<?= $hour['hours']; ?>"
class="form-control"
>

</div>

<?php } ?>

<button
name="save"
class="btn btn-warning"
>

Enregistrer

</button>

</form>

</section>

<?php include '../includes/footer.php'; ?>