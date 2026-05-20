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

🍽️ Thème :
<?= $menu['theme']; ?>

</p>

<p>

🥗 Régime :
<?= $menu['regime']; ?>

</p>

<p>

👥 Minimum :
<?= $menu['min_people']; ?> personnes

</p>

<p>

💶 Prix :
<?= $menu['price']; ?> €

</p>
<hr>

<h4>

Composition du menu

</h4>

<?php if($menu['theme']=="Italien"){ ?>

<ul>

<li>
🥗 Entrée : Bruschetta
</li>

<li>
🍝 Plat : Lasagnes maison
</li>

<li>
🍰 Dessert : Tiramisu
</li>

</ul>

<p>

⚠️ Allergènes :
Gluten • Lait • Œufs

</p>

<?php } ?>

<?php if($menu['theme']=="Mexicain"){ ?>

<ul>

<li>
🥗 Entrée : Nachos
</li>

<li>
🌮 Plat : Tacos au choix
</li>

<li>
🍮 Dessert : Churros
</li>

</ul>

<p>

⚠️ Allergènes :
Gluten • Produits laitiers

</p>

<?php } ?>

<?php if($menu['theme']=="Oriental"){ ?>

<ul>

<li>
🥗 Entrée : Salade orientale
</li>

<li>
🍗 Plat : Couscous royal
</li>

<li>
🍯 Dessert : Pâtisseries orientales
</li>

</ul>

<p>

⚠️ Allergènes :
Gluten • Fruits à coque

</p>

<?php } ?>

<?php if($menu['theme']=="Japonais"){ ?>

<ul>

<li>
🥗 Entrée : Salade wakame
</li>

<li>
🍣 Plat : Assortiment sushi
</li>

<li>
🍡 Dessert : Mochi
</li>

</ul>

<p>

⚠️ Allergènes :
Poisson • Soja • Gluten

</p>

<?php } ?>

<?php if($menu['theme']=="Evenement"){ ?>

<ul>

<li>
🥗 Entrée : Buffet découverte
</li>

<li>
🍽️ Plat : Menu signature adapté à l'événement
</li>

<li>
🍰 Dessert : Dessert personnalisé selon le thème
(anniversaire, Noël, ou événement privé type mariage)
</li>

</ul>

<p>

⚠️ Allergènes :
Variables selon les plats sélectionnés

</p>

<?php } ?>
<hr>

<h4>

‼️Conditions

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