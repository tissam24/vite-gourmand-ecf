<?php

include '../config/database.php';

$id = $_GET['id'];

$sql =
"SELECT * FROM menus WHERE id=?";

$query =
$pdo->prepare($sql);

$query->execute([$id]);

$menu =
$query->fetch();

include '../includes/header.php';

?>

<section class="container py-5">

<div class="row">

<div class="col-md-6">

<img
src="../assets/images/<?= $menu['image']; ?>"
class="img-fluid rounded shadow"
>

</div>

<div class="col-md-6">

<h1>

<?= $menu['title']; ?>

</h1>

<p class="mt-4">

<?= $menu['description']; ?>

</p>

<hr>

<p>

<i class="bi bi-egg-fried"></i> Thème :
<?= $menu['theme']; ?>

</p>

<p>

<i class="bi bi-heart-pulse"></i> Régime :
<?= $menu['regime']; ?>

</p>

<p>

<i class="bi bi-people-fill"></i> Minimum :
<?= $menu['min_people']; ?> personnes

</p>

<p>

<i class="bi bi-currency-euro"></i> Prix :
<?= $menu['price']; ?> €

</p>
<hr>

<h4>

Composition du menu

</h4>

<?php if($menu['theme']=="Italien"){ ?>

<ul>

<li>
<i class="bi bi-egg"></i> Entrée : Bruschetta
</li>

<li>
<i class="bi bi-egg-fried"></i> Plat : Lasagnes maison
</li>

<li>
<i class="bi bi-cake"></i> Dessert : Tiramisu
</li>

</ul>

<p>

<i class="bi bi-exclamation-triangle-fill"></i> Allergènes :
Gluten • Lait • Œufs

</p>

<?php } ?>

<?php if($menu['theme']=="Mexicain"){ ?>

<ul>

<li>
<i class="bi bi-egg"></i> Entrée : Nachos
</li>

<li>
<i class="bi bi-egg-fried"></i> Plat : Tacos au choix
</li>

<li>
<i class="bi bi-cake"></i> Dessert : Churros
</li>

</ul>

<p>

<i class="bi bi-exclamation-triangle-fill"></i> Allergènes :
Gluten • Produits laitiers

</p>

<?php } ?>

<?php if($menu['theme']=="Oriental"){ ?>

<ul>

<li>
<i class="bi bi-egg"></i> Entrée : Salade orientale
</li>

<li>
<i class="bi bi-egg-fried"></i> Plat : Couscous royal
</li>

<li>
<i class="bi bi-cake"></i> Dessert : Pâtisseries orientales
</li>

</ul>

<p>

<i class="bi bi-exclamation-triangle-fill"></i> Allergènes :
Gluten • Fruits à coque

</p>

<?php } ?>

<?php if($menu['theme']=="Japonais"){ ?>

<ul>

<li>
<i class="bi bi-egg"></i> Entrée : Salade wakame
</li>

<li>
<i class="bi bi-egg-fried"></i> Plat : Assortiment sushi
</li>

<li>
<i class="bi bi-cake"></i> Dessert : Mochi
</li>

</ul>

<p>

<i class="bi bi-exclamation-triangle-fill"></i> Allergènes :
Poisson • Soja • Gluten

</p>

<?php } ?>

<?php if($menu['theme']=="Evenement"){ ?>

<ul>

<li>
<i class="bi bi-egg"></i> Entrée : Buffet découverte
</li>

<li>
<i class="bi bi-egg-fried"></i> Plat : Menu signature adapté à l'événement
</li>

<li>
<i class="bi bi-cake"></i> Dessert : Dessert personnalisé selon le thème
(anniversaire, Noël, ou événement privé type mariage)
</li>

</ul>

<p>

<i class="bi bi-exclamation-triangle-fill"></i> Allergènes :
Variables selon les plats sélectionnés

</p>

<?php } ?>
<hr>

<h4>

<i class="bi bi-exclamation-octagon-fill"></i> Conditions

</h4>

<ul>

<li>
Réservation minimum 48h à l'avance
</li>

<li>
Disponible selon les saisons
</li>

<li>
Modification jusqu'à 24h avant
</li>

<li>
Livraison selon zone
</li>

</ul>

<a
href="order.php?menu_id=<?= $menu['id']; ?>"
class="btn btn-warning btn-lg"
>

Commander ce menu

</a>

</div>

</div>

</section>

<?php include '../includes/footer.php'; ?>