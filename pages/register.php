<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

$firstname = htmlspecialchars($_POST['firstname']);

$lastname = htmlspecialchars($_POST['lastname']);

$phone = htmlspecialchars($_POST['phone']);

$address = htmlspecialchars($_POST['address']);

$email = htmlspecialchars($_POST['email']);

$password = $_POST['password'];

if(
!preg_match(
'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{10,}$/',
$password
)
){

$message =
"Mot de passe : minimum 10 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.";

}else{

// Vérifie email déjà utilisé

$check =
$pdo->prepare(
"SELECT id FROM users WHERE email=:email"
);

$check->execute([
'email'=>$email
]);

if($check->fetch()){

$message =
"Cet email existe déjà.";

}else{

$hashedPassword =
password_hash(
$password,
PASSWORD_DEFAULT
);

$role_id = 1;

// Création utilisateur

$sql = "

INSERT INTO users
(
firstname,
lastname,
phone,
address,
email,
password,
role_id
)

VALUES
(
:firstname,
:lastname,
:phone,
:address,
:email,
:password,
:role_id
)

";

$query =
$pdo->prepare($sql);

$query->execute([

'firstname'=>$firstname,

'lastname'=>$lastname,

'phone'=>$phone,

'address'=>$address,

'email'=>$email,

'password'=>$hashedPassword,

'role_id'=>$role_id

]);

// ENVOI EMAIL

try{

$mail =
new PHPMailer(true);

$mail->isSMTP();

$mail->Host =
'smtp.gmail.com';

$mail->SMTPAuth =
true;

// TON EMAIL

$mail->Username =
'tissam2405@gmail.com';

// MOT DE PASSE APPLICATION

$mail->Password =
'qmjq ilin rimb aegp';

$mail->SMTPSecure =
PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port =
587;

$mail->CharSet =
'UTF-8';

$mail->setFrom(
'tissam2405@gmail.com',
'Vite & Gourmand'
);

$mail->addAddress(
$email
);

$mail->isHTML(true);

$mail->Subject =
'Bienvenue chez Vite & Gourmand';

$mail->Body = "

<h2>Bonjour $firstname 👋</h2>

<p>Votre compte a été créé avec succès.</p>

<p>Vous pouvez maintenant vous connecter.</p>

<p>Julie & José</p>

";

$mail->send();

$message =
"Compte créé avec succès. Email envoyé.";

}

catch(Exception $e){

$message =
"Compte créé mais email impossible : "
.
$mail->ErrorInfo;

}

}

}

}

?>

<?php include '../includes/header.php'; ?>

<section
class="container mt-5"
style="max-width:600px;"
>

<h1 class="mb-4">

Inscription

</h1>

<?php if($message): ?>

<div class="alert <?= str_contains($message,'impossible') || str_contains($message,'Mot de passe') || str_contains($message,'existe') ? 'alert-danger' : 'alert-success'; ?>">

<?= $message ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>

Prénom

</label>

<input
type="text"
name="firstname"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Nom

</label>

<input
type="text"
name="lastname"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Téléphone

</label>

<input
type="text"
name="phone"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Adresse

</label>

<input
type="text"
name="address"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Mot de passe

</label>

<input
type="password"
name="password"
class="form-control"
required>

<small>

Minimum 10 caractères,
1 majuscule,
1 minuscule,
1 chiffre,
1 caractère spécial.

</small>

</div>

<button
class="btn btn-success w-100"
>

Créer un compte

</button>

</form>

</section>

<?php include '../includes/footer.php'; ?>