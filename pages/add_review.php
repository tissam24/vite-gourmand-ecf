<?php

session_start();

include '../config/mongodb.php';

if(
!isset($_SESSION['user'])
){

die(
"Connexion requise"
);

}

if(
$_SERVER['REQUEST_METHOD']
===
'POST'
){

$reviewsCollection
->insertOne([

'user'=>

$_SESSION['user']['firstname'],

'order_id'=>

(int)
$_POST['order_id'],

'comment'=>

trim(
$_POST['comment']
),

'rating'=>

(int)
$_POST['rating'],

'status'=>

'pending',

'created_at'=>

date(
'Y-m-d H:i:s'
)

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

Donner un avis

</h2>

<form method="POST">

<input
type="hidden"
name="order_id"
value="<?= $_GET['order_id'] ?>"
>

<label>

Note

</label>

<select
name="rating"
class="form-select mb-3"
required
>

<option value="1">

1 étoile

</option>

<option value="2">

2 étoiles

</option>

<option value="3">

3 étoiles

</option>

<option value="4">

4 étoiles

</option>

<option value="5">

5 étoiles

</option>

</select>

<label>

Commentaire

</label>

<textarea

name="comment"

class="form-control mb-3"

required

></textarea>

<button
class="btn btn-success"
>

Envoyer avis

</button>

</form>

</section>

<?php include '../includes/footer.php'; ?>