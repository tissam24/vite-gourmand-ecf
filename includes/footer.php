<footer class="bg-dark text-white mt-5">

    <div class="container py-5">

        <div class="row">

            <div class="col-md-4 mb-4">

                <div class="d-flex align-items-center mb-3">

    <img 
        src="/assets/images/logo.png"
        alt="Logo"
        width="50"
        height="50"
        class="rounded-circle me-3"
        style="object-fit: cover;"
    >

    <h4 class="mb-0 text-warning">

        Vite & Gourmand

    </h4>

</div>

                <p>

                    Plateforme de restauration événementielle premium.

                </p>

            </div>

            <div class="col-md-4 mb-4">

<h4 class="mb-3 text-warning">

Liens utiles

</h4>

<ul class="list-unstyled">

<li class="mb-2">

<a
href="/index.php"
class="text-white text-decoration-none"
>

Accueil

</a>

</li>

<li class="mb-2">

<a
href="/pages/menus.php"
class="text-white text-decoration-none"
>

Menus

</a>

</li>

<li class="mb-2">

<a
href="/pages/mentions-legales.php"
class="text-white text-decoration-none"
>

Mentions légales

</a>

</li>

<li class="mb-2">

<a
href="/pages/cgv.php"
class="text-white text-decoration-none"
>

Conditions Générales de Vente

</a>

</li>

</ul>

</div>

            <div class="col-md-4 mb-4">

<h4 class="mb-3 text-warning">

Contact

</h4>

<p>
📧 contact@vitegourmand.fr
</p>

<p>
📞 01 23 45 67 89
</p>

<p>
📍 Bordeaux, France
</p>

<hr>

<h5 class="text-warning">

Horaires

</h5>

<?php

$sql=
"SELECT *
FROM opening_hours";

$query=
$pdo->query(
$sql
);

$hours=
$query->fetchAll();

foreach(
$hours
as
$hour
){

?>

<p>

<?= $hour['day_name']; ?>

:

<?= $hour['hours']; ?>

</p>

<?php } ?>

</div>

    <div class="bg-black text-center py-3">

        © <?= date('Y'); ?> Vite & Gourmand — Tous droits réservés.

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>