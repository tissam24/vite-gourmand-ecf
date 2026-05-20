<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vite & Gourmand</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a 
    class="navbar-brand d-flex align-items-center"
    href="/index.php"
>

    <img 
        src="/assets/images/logo.png"
        alt="Logo"
        width="45"
        height="45"
        class="rounded-circle me-2"
        style="object-fit: cover;"
    >

    <span>

        Vite & Gourmand

    </span>

</a>

        <ul class="navbar-nav ms-auto">

            <li class="nav-item">

                <a class="nav-link" href="/index.php">
                    Accueil
                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link" href="/pages/menus.php">
                    Menus
                </a>

            </li>

            <li class="nav-item">

                <a class="nav-link" href="/pages/contact.php">
                    Contact
                </a>

            </li>

            <?php if (isset($_SESSION['user'])) { ?>
            

                <li class="nav-item">

                    <span class="nav-link text-warning">

                        Bonjour <?= $_SESSION['user']['firstname']; ?>

                    </span>

                </li>
                <li class="nav-item">

    <a class="nav-link" href="/user/dashboard.php">

        Mes commandes

    </a>


</li>
<li class="nav-item">

<a
class="nav-link"
href="/pages/profile.php"
>

Mon profil

</a>

</li>
<?php if ($_SESSION['user']['role_id'] == 2) { ?>

<?php } ?>
<?php if ($_SESSION['user']['role_id'] == 2) { ?>

<li class="nav-item">

<a class="nav-link text-success" href="/employee/orders.php">

Gestion Commandes

</a>

</li>

<?php } ?>

                <li class="nav-item">

                    <a class="nav-link" href="/pages/logout.php">

                        Déconnexion

                    </a>

                </li>

            <?php } else { ?>

                <li class="nav-item">

                    <a class="nav-link" href="/pages/login.php">

                        Connexion

                    </a>
                    <li class="nav-item">

    <a class="nav-link" href="/pages/register.php">

        Inscription

    </a>

</li>

                </li>

            <?php } ?>
<?php if(
isset($_SESSION['user'])
&&
$_SESSION['user']['role_id']==3
){ ?>

<li class="nav-item">

<a
class="nav-link text-danger fw-bold"
href="/admin/dashboard.php"
>

ADMIN

</a>

</li>

<?php } ?>

<?php if(
isset($_SESSION['user'])
&&
(
$_SESSION['user']['role_id']==2
||
$_SESSION['user']['role_id']==3
)
){ ?>

<li class="nav-item">

<a
class="nav-link"
href="/pages/manage-menus.php"
>

Gestion menus

</a>

</li>

<li class="nav-item">

<a
class="nav-link"
href="/pages/edit-hours.php"
>

Horaires

</a>

</li>

<?php } ?>
        </ul>

    </div>

</nav>