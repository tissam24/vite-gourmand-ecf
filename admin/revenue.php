<?php

session_start();

include '../config/database.php';

$menus =
$pdo
->query(
"SELECT id,title FROM menus ORDER BY title"
)
->fetchAll();

$total=0;

$sql="

SELECT

SUM(total_price)

AS total

FROM orders

WHERE 1=1

";

$params=[];

if(
!empty($_GET['menu'])
){

$sql .=
" AND menu_id=:menu";

$params['menu']
=
$_GET['menu'];

}

if(
!empty($_GET['start'])
){

$sql .=
" AND DATE(created_at)>=:start";

$params['start']
=
$_GET['start'];

}

if(
!empty($_GET['end'])
){

$sql .=
" AND DATE(created_at)<=:end";

$params['end']
=
$_GET['end'];

}

$query=
$pdo->prepare(
$sql
);

$query->execute(
$params
);

$result=
$query->fetch();

$total=
$result['total']
??
0;

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

<h1>

Chiffre d'affaires

</h1>

<form>

<select
name="menu"
class="form-select mb-3"
>

<option value="">

Tous les menus

</option>

<?php foreach($menus as $menu): ?>

<option
value="<?= $menu['id'] ?>"

<?=
isset($_GET['menu'])
&&
$_GET['menu']
==
$menu['id']

?

'selected'

:

''

?>

>

<?= $menu['title'] ?>

</option>

<?php endforeach; ?>

</select>

<input
type="date"
name="start"
class="form-control mb-3">

<input
type="date"
name="end"
class="form-control mb-3">

<button
class="btn btn-primary">

Calculer

</button>

</form>

<div
class="alert alert-success mt-4"
>

CA :

<?=

number_format(
$total,
2
)

?>

€

</div>

</section>

<?php include '../includes/footer.php'; ?> 