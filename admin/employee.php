<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

include '../config/database.php';

$sql="

SELECT
id,
firstname,
lastname,
email,
is_active

FROM users

WHERE role_id=2

ORDER BY id DESC

";

$query=$pdo->query($sql);

$employees=$query->fetchAll();

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

<h1 class="mb-4">

Gestion employés

</h1>

<table class="table table-bordered">

<tr>

<th>Nom</th>

<th>Email</th>

<th>Statut</th>

<th>Action</th>

</tr>

<?php foreach($employees as $employee){ ?>

<tr>

<td>

<?= $employee['firstname'] ?>

<?= $employee['lastname'] ?>

</td>

<td>

<?= $employee['email'] ?>

</td>

<td>

<?=
$employee['is_active']
?
'Actif'
:
'Désactivé'
?>

</td>

<td>

<a
href="toggle_employee.php?id=<?= $employee['id'] ?>"
class="btn btn-danger">

<?=

$employee['is_active']

?

'Désactiver'

:

'Réactiver'

?>

</a>

</td>

</tr>

<?php } ?>

</table>

</section>

<?php include '../includes/footer.php'; ?>