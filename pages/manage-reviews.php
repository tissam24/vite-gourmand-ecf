<?php

session_start();

include '../config/mongodb.php';

if(

$_SESSION['user']['role_id']
!=2

&&

$_SESSION['user']['role_id']
!=3

){

die(
"Accès refusé"
);

}

if(
isset($_GET['validate'])
){

$reviewsCollection
->updateOne(

[
'_id'=>

new MongoDB\BSON\ObjectId(
$_GET['validate']
)

],

[
'$set'=>

[
'status'
=>
'validated'
]

]

);

header(
"Location: manage_review.php"
);

exit;

}

if(
isset($_GET['reject'])
){

$reviewsCollection
->updateOne(

[
'_id'=>

new MongoDB\BSON\ObjectId(
$_GET['reject']
)

],

[
'$set'=>

[
'status'
=>
'rejected'
]

]

);

header(
"Location: manage_review.php"
);

exit;

}

$reviews=

$reviewsCollection
->find([

'status'=>
'pending'

]);

include
'../includes/header.php';

?>

<section class="container py-5">

<h1>

Gestion des avis

</h1>

<?php foreach($reviews as $review){ ?>

<div class="card p-4 mb-3">

<h4>

<?= $review['user']; ?>

</h4>

<p>

<?= $review['comment']; ?>

</p>

<p>

⭐

<?= $review['rating']; ?>

</p>

<div class="d-flex gap-2">

<a
href="?validate=<?= $review['_id']; ?>"
class="btn btn-success"
>

Valider

</a>

<a
href="?reject=<?= $review['_id']; ?>"
class="btn btn-danger"
>

Refuser

</a>

</div>

</div>

<?php } ?>

<?php if(iterator_count($reviews)==0){ ?>

<div class="alert alert-info">

Aucun avis en attente.

</div>

<?php } ?>

</section>

<?php include '../includes/footer.php'; ?>