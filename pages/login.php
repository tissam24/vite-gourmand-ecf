<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = htmlspecialchars($_POST['email']);

    $password = $_POST['password'];

    $sql = "

    SELECT *

    FROM users

    WHERE email = :email

    ";

    $query = $pdo->prepare($sql);

    $query->execute([

        'email' => $email

    ]);

    $user = $query->fetch();

    if ($user) {

        if (
            isset($user['is_active'])
            &&
            $user['is_active'] == false
        ) {

            $message =
            "Compte désactivé. Contactez l'administrateur.";

        }

        elseif (

            password_verify(
                $password,
                $user['password']
            )

        ) {

            $_SESSION['user'] = [

                'id' => $user['id'],

                'firstname' => $user['firstname'],

                'lastname' => $user['lastname'],

                'email' => $user['email'],

                'role_id' => $user['role_id']

            ];

            $_SESSION['success'] =
            "Connecté";

            header(
                "Location: ../index.php"
            );

            exit;

        }

        else {

            $message =
            "Mot de passe incorrect";

        }

    }

    else {

        $message =
        "Utilisateur introuvable";

    }

}

?>

<?php include '../includes/header.php'; ?>

<section
class="container mt-5"
style="max-width:500px;"
>

<h1 class="mb-4">

Connexion

</h1>

<?php if ($message): ?>

<div class="alert alert-danger">

<?= $message; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Mot de passe

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-primary w-100"
>

Se connecter

</button>

<p class="text-center mt-3">

<a
href="forgot-password.php"
class="text-decoration-none"
>

Mot de passe oublié ?

</a>

</p>

</form>

</section>

<?php include '../includes/footer.php'; ?>