<?php

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../config/database.php';

$message="";

if($_SERVER["REQUEST_METHOD"]==="POST"){

$email=
trim($_POST["email"]);

$query=
$pdo->prepare(
"
SELECT *
FROM users
WHERE email=:email
"
);

$query->execute([
'email'=>$email
]);

$user=
$query->fetch();

if($user){

$token=
bin2hex(
random_bytes(32)
);

$expire=
date(
'Y-m-d H:i:s',
strtotime('+1 hour')
);

$update=
$pdo->prepare(
"

UPDATE users

SET

reset_token=:token,

reset_expires=:expire

WHERE email=:email

"

);

$update->execute([

'token'=>$token,

'expire'=>$expire,

'email'=>$email

]);

$link =
"http://localhost:8080/pages/reset-password.php?token=".$token;

try{

$mail=
new PHPMailer(true);

$mail->isSMTP();

$mail->Host=
'smtp.gmail.com';

$mail->SMTPAuth=
true;

$mail->Username=
'tissam2405@gmail.com';

$mail->Password=
'qmjq ilin rimb aegp';

$mail->SMTPSecure=
PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port=
587;

$mail->CharSet=
'UTF-8';

$mail->setFrom(
'TON_EMAIL@gmail.com',
'Vite & Gourmand'
);

$mail->addAddress(
$email
);

$mail->isHTML(true);

$mail->Subject=
'Réinitialisation mot de passe';

$mail->Body=

"

<h2>Réinitialisation</h2>

<p>Bonjour,</p>

<p>Cliquez ici :</p>

<a href='$link'>

Réinitialiser mon mot de passe

</a>

<p>Valable 1 heure.</p>

";

$mail->send();

$message=
"Lien envoyé par email.";

}

catch(Exception $e){

$message=
"Erreur email : ".
$mail->ErrorInfo;

}

}else{

$message=
"Adresse email introuvable.";

}

}

?>

<?php include '../includes/header.php'; ?>

<section
class="container py-5"
style="max-width:500px;"
>

<h1 class="mb-4">

Mot de passe oublié

</h1>

<p class="text-muted">

Entrez votre adresse mail pour recevoir un lien.

</p>

<?php if($message): ?>

<div class="alert alert-info">

<?= $message ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>

Adresse mail

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<button
class="btn btn-warning w-100"
>

Envoyer le lien

</button>

</form>

</section>

<?php include '../includes/footer.php'; ?>