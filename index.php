<?php

include 'config/database.php';

if($pdo===null){

echo "
<h1>Vite & Gourmand</h1>
<p>Application déployée avec succès.</p>
<p>Certaines fonctionnalités nécessitent une base de données active.</p>
";

exit;

}

?>

<?php

include 'config/database.php';

include 'includes/header.php';

include 'config/mongodb.php';

$reviews = $reviewsCollection->find([
    'status' => 'validated'
]);
?>



<section 
    class="text-white text-center d-flex align-items-center"
    style="
        height: 90vh;
        background-image: url('https://images.unsplash.com/photo-1555244162-803834f70033');
        background-size: cover;
        background-position: center;
    "
>

    <div 
        class="container"
        style="
            background: rgba(0,0,0,0.6);
            padding: 50px;
            border-radius: 20px;
        "
    >

        <h1 class="display-3 fw-bold mb-4">

            Vite & Gourmand

        </h1>

        <p class="lead mb-4">

            Commandez des menus événementiels premium
            pour vos soirées, mariages et événements.

        </p>

        <a 
            href="/pages/menus.php"
            class="btn btn-warning btn-lg me-3"
        >

            Voir les menus

        </a>

        <a 
            href="/pages/register.php"
            class="btn btn-outline-light btn-lg"
        >

            Créer un compte

        </a>

    </div>

</section>

<section class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold">

            Pourquoi choisir Vite & Gourmand ?

        </h2>

        <p class="text-muted">

            Une plateforme moderne de restauration événementielle.

        </p>

    </div>

    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100 text-center p-4">

                <div class="card-body">

                    <h3 class="mb-3">
                        🍽️ Menus Premium
                    </h3>

                    <p>

                        Des menus variés adaptés à tous les événements.

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100 text-center p-4">

                <div class="card-body">

                    <h3 class="mb-3">
                        🚚 Livraison Rapide
                    </h3>

                    <p>

                        Une organisation rapide et efficace.

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card border-0 shadow h-100 text-center p-4">

                <div class="card-body">

                    <h3 class="mb-3">
                        ⭐ Service Professionnel
                    </h3>

                    <p>

                        Une expérience premium pour vos invités.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="bg-dark text-white py-5">

    <div class="container text-center">

        <h2 class="mb-4">

            Prêt à commander votre événement ?

        </h2>

        <a 
            href="/pages/menus.php"
            class="btn btn-warning btn-lg"
        >

            Découvrir les menus

        </a>

    </div>

</section>
<section class="container py-5">

<div class="text-center mb-5">

<h2 class="fw-bold">

Notre histoire

</h2>

<p class="text-muted">

Découvrez l'univers de Vite & Gourmand.

</p>

</div>

<div class="row align-items-center">

<div class="col-md-7">

<h3 class="mb-4">

Une histoire de passion depuis 25 ans

</h3>

<p>

Depuis plus de 25 ans à Bordeaux, Vite & Gourmand accompagne particuliers et professionnels pour leurs événements.

</p>

<p>

Créée par Julie et José, l’entreprise propose des menus événementiels évolutifs adaptés aux saisons et aux envies des clients.

</p>

<p>

Dans une ambiance chaleureuse et conviviale, le restaurant met l’accent sur la qualité, le partage et le plaisir de se retrouver autour d’un repas.

</p>

<p>

Aujourd’hui, grâce à cette application web, chacun peut découvrir les menus plus facilement et commander pour ses événements en quelques clics.

</p>

</div>

<div class="col-md-5">

<div class="card shadow border-0 p-4">

<h4>

👩 Julie

</h4>

<p>

Co-gérante, elle imagine les menus et veille à offrir une expérience conviviale et de qualité.

</p>

<hr>

<h4>

👨 José

</h4>

<p>

Co-gérant, il supervise l’organisation et garantit un service professionnel pour chaque événement.

</p>

</div>

</div>

</div>

</section>

<section class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold">

            Avis Clients

        </h2>

        <p class="text-muted">

            Découvrez les retours de nos clients.

        </p>

    </div>

    <div class="row">

        <?php foreach ($reviews as $review) { ?>

            <div class="col-md-4 mb-4">

                <div class="card shadow border-0 h-100">

                    <div class="card-body">

                        <h4 class="mb-3">

                            <?= $review['user']; ?>

                        </h4>

                        <p>

                            ⭐ <?= $review['rating']; ?>/5

                        </p>

                        <p class="text-muted">

                            <?= $review['comment']; ?>

                        </p>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</section>
<?php include 'includes/footer.php'; ?>