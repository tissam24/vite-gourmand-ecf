<?php

session_start();

include '../config/database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$message="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$firstname=trim($_POST['firstname'] ?? '');

$lastname=trim($_POST['lastname'] ?? '');

$email=trim($_POST['email'] ?? '');

$password=password_hash(
$_POST['password'] ?? '',
PASSWORD_DEFAULT
);

$sql="

INSERT INTO users(

firstname,
lastname,
email,
password,
role_id

)

VALUES(

:firstname,
:lastname,
:email,
:password,
2

)

";

$stmt=$pdo->prepare($sql);

try{

$stmt->execute([

':firstname'=>$firstname,
':lastname'=>$lastname,
':email'=>$email,
':password'=>$password

]);

$mail = new PHPMailer(true);

/* ton code mail */

$message=
'Employé créé et mail envoyé';

}

catch(PDOException $e){

$message=
'Cet email existe déjà';

}

$mail = new PHPMailer(true);

try{
    $mail->isSMTP();

$mail->Host = 'smtp.gmail.com';

$mail->SMTPAuth = true;

$mail->Username = 'tissam2405@gmail.com';

$mail->Password = 'qmjq ilin rimb aegp';

$mail->SMTPSecure =
PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port = 587;

$mail->setFrom(
'tissam2405@gmail.com',
'Vite & Gourmand'
);

$mail->addAddress($email);

$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

$mail->Subject =
'Votre compte a été créé';

$mail->Body = "

Bonjour $firstname $lastname,<br><br>

Un compte employé a été créé pour vous.<br><br>

Identifiant : $email<br><br>

Veuillez contacter l'administrateur
pour obtenir votre mot de passe.

";

$mail->send();

$message=
'Employé créé et mail envoyé';

}

catch(Exception $e){

$message=
'Employé créé mais mail non envoyé';

}

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Créer employé</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="container mt-5">

<h2>Créer un employé</h2>

<?php if($message){ ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="firstname"
placeholder="Prénom"
class="form-control mb-3"
required>

<input
type="text"
name="lastname"
placeholder="Nom"
class="form-control mb-3"
required>

<input
type="email"
name="email"
placeholder="Email"
class="form-control mb-3"
required>

<input
type="password"
name="password"
placeholder="Mot de passe"
class="form-control mb-3"
required>

<button
class="btn btn-success">

Créer

</button>

</form>

</body>

</html>