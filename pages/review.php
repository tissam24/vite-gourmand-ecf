<?php

session_start();

include '../config/mongodb.php';

if(
!isset($_SESSION['user'])
){

header(
"Location: login.php"
);

exit;

}

if(
$_SERVER['REQUEST_METHOD']
==="POST"
){

$reviewsCollection
->insertOne([

'user'=>

$_SESSION[
'user'
]['firstname'],

'rating'=>

(int)
$_POST[
'rating'
],

'comment'=>

$_POST[
'comment'
],

'status'=>

'pending'

]);

$success=true;

}

include
'../includes/header.php';

?>

<section class="container py-5">

<div class="card p-5">

<h2>

Donner un avis

</h2>

<?php if(
isset($success)
){ ?>

<div class="alert alert-success">

Avis envoyé 🎉

Il sera affiché après validation.

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label>

Note

</label>

<select
name="rating"
class="form-select"
required
>

<option value="1">
1
</option>

<option value="2">
2
</option>

<option value="3">
3
</option>

<option value="4">
4
</option>

<option value="5">
5
</option>

</select>

</div>

<div class="mb-3">

<label>

Commentaire

</label>

<textarea
name="comment"
class="form-control"
rows="4"
required
></textarea>

</div>

<button
class="btn btn-warning"
>

Envoyer

</button>

</form>

</div>

</section>

<?php include '../includes/footer.php'; ?>