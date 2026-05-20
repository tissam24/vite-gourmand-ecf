<?php

include '../includes/header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $email = trim($_POST["email"]);

    if (!empty($title) && !empty($description) && !empty($email)) {

        try {

            $mail = new PHPMailer(true);

            $mail->isSMTP();

            // Mets EXACTEMENT la même config que création employé
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'tissam2405@gmail.com';
            $mail->Password = 'qmjq ilin rimb aegp';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = 587;

            // Mail envoyé depuis ton adresse SMTP
            $mail->setFrom('tissam2405@gmail.com', 'Vite & Gourmand');

            // Mail reçu par l'entreprise
            $mail->addAddress('tissam2405@gmail.com');

            // Réponse au visiteur
            $mail->addReplyTo($email);

            $mail->isHTML(true);

            $mail->Subject = $title;

            $mail->Body = "
                <h2>Nouveau message de contact</h2>

                <p><strong>Email :</strong> {$email}</p>

                <p><strong>Message :</strong></p>

                <p>{$description}</p>
            ";

            $mail->send();

            $message = "Message envoyé avec succès.";

        } catch (Exception $e) {

            $message = "Erreur : " . $mail->ErrorInfo;

        }

    } else {

        $message = "Tous les champs sont obligatoires.";

    }
}

?>

<section class="container mt-5" style="max-width: 700px;">

    <h1 class="mb-4">
        Contact
    </h1>

    <?php if (!empty($message)) : ?>

        <div class="alert alert-info">

            <?= $message ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">
                Titre
            </label>

            <input
                type="text"
                name="title"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label class="form-label">
                Message
            </label>

            <textarea
                name="description"
                class="form-control"
                rows="5"
                required
            ></textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Envoyer
        </button>

    </form>

</section>

<?php include '../includes/footer.php'; ?>