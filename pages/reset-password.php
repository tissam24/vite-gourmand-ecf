<?php

include '../config/database.php';

$message="";

$token=
$_GET["token"]
?? "";

if(!$token){

die("Lien invalide");

}

if($_SERVER["REQUEST_METHOD"]==="POST"){

$password=
trim($_POST["password"]);

if(
!preg_match(
'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{10,}$/',
$password
)
){

$message=
"Mot de passe : minimum 10 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.";

}else{

$hashed=
password_hash(
$password,
PASSWORD_DEFAULT
);

$update=
$pdo->prepare(

"

UPDATE users

SET

password=:password,

reset_token=NULL,

reset_expires=NULL

WHERE reset_token=:token

"

);

$update->execute([

'password'=>$hashed,

'token'=>$token

]);

if(
$update->rowCount()
){

$message=
"Mot de passe réinitialisé avec succès.";

}else{

$message=
"Lien invalide.";

}

}

} // ← CELLE-CI MANQUAIT

?>

<?php include '../includes/header.php'; ?>

<section
class="container py-5"
style="max-width:500px;"
>

<h1>

Réinitialisation

</h1>

<?php if($message): ?>

<div class="alert <?= str_contains($message,'succès') ? 'alert-success' : 'alert-danger'; ?>">

<?= $message ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>

Nouveau mot de passe

</label>

<input
type="password"
name="password"
class="form-control"
required>

<small class="text-muted">

Minimum 10 caractères,
1 majuscule,
1 minuscule,
1 chiffre,
1 caractère spécial.

</small>

</div>

<button
class="btn btn-success w-100">

Réinitialiser

</button>

</form>

</section>

<?php include '../includes/footer.php'; ?>