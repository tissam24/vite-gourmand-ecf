<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/../vendor/autoload.php';

function sendMail(
$to,
$subject,
$body
){

$mail =
new PHPMailer(true);

try{

$mail->isSMTP();

$mail->Host =
'smtp.gmail.com';

$mail->SMTPAuth =
true;

$mail->Username =
'tissam2405@gmail.com';

$mail->Password =
'qmjqilinrimbaegp';

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
$to
);

$mail->isHTML(
true
);

$mail->Subject =
$subject;

$mail->Body =
$body;

$mail->send();

echo "MAIL ENVOYÉ";

}
catch(Exception $e){

die(
"Erreur mail : "
.
$mail->ErrorInfo
);

}

}