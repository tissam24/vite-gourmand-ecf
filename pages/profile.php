<?php

session_start();

include '../config/database.php';

if(!isset($_SESSION['user'])){

header("Location: login.php");

exit;

}
if($_SERVER['REQUEST_METHOD']=="POST"){

$sql=
"UPDATE users
SET

lastname=?,
firstname=?,
email=?,
phone=?,
address=?

WHERE id=?";

$query=
$pdo->prepare($sql);

$query->execute([

$_POST['lastname'],

$_POST['firstname'],

$_POST['email'],

$_POST['phone'],

$_POST['address'],

$_SESSION['user']['id']

]);

$_SESSION['user']['lastname'] = $_POST['lastname'];

$_SESSION['user']['firstname'] = $_POST['firstname'];

$_SESSION['user']['email'] = $_POST['email'];

$_SESSION['user']['phone'] = $_POST['phone'];

$_SESSION['user']['address'] = $_POST['address'];

header(
"Location: profile.php"
);

exit;

}
$user=$_SESSION['user'];

?>

<?php include '../includes/header.php'; ?>

<section class="container py-5">

<div class="card shadow p-5">

<h2>

Mon profil

</h2>

<form method="POST">

<div class="mb-3">

<label>

Nom

</label>

<input
type="text"
name="lastname"
class="form-control"
value="<?= $user['lastname']; ?>"
>

</div>

<div class="mb-3">

<label>

Prénom

</label>

<input
type="text"
name="firstname"
class="form-control"
value="<?= $user['firstname']; ?>"
>

</div>

<div class="mb-3">

<label>

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= $user['email']; ?>"
>

</div>

<div class="mb-3">

<label>

Téléphone

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= $user['phone'] ?? ''; ?>"
>

</div>

<div class="mb-3">

<label>

Adresse

</label>

<textarea
name="address"
class="form-control"
><?= $user['address'] ?? ''; ?></textarea>

</div>

<button
class="btn btn-warning"
>

Enregistrer

</button>

</form>

</div>

</section>

<?php include '../includes/footer.php'; ?>