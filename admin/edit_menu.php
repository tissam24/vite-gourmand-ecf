<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include '../config/database.php';

if (!isset($_SESSION['user'])) {

    header("Location: ../pages/login.php");
    exit;
}

if(

$_SESSION['user']['role_id']!=3

&&

$_SESSION['user']['role_id']!=2

){

die(
"Accès refusé"
);

}

if (!isset($_GET['id'])) {

    die("Menu introuvable");
}

$id = $_GET['id'];

/*
RÉCUPÉRATION MENU
*/

$sqlMenu = "SELECT * FROM menus WHERE id = :id";

$queryMenu = $pdo->prepare($sqlMenu);

$queryMenu->execute([
    'id' => $id
]);

$menu = $queryMenu->fetch();

if (!$menu) {

    die("Menu inexistant");
}

/*
UPDATE
*/

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$title = htmlspecialchars($_POST['title']);

$description = htmlspecialchars($_POST['description']);

$theme = htmlspecialchars($_POST['theme']);

$regime = htmlspecialchars($_POST['regime']);

$min_people = $_POST['min_people'];

$price = $_POST['price'];

$stock = $_POST['stock'];

$conditions = htmlspecialchars($_POST['conditions']);

$imageName = $menu['image'];

/*
IMAGE
*/

if (!empty($_FILES['image']['name'])) {

$imageName =
time()
.
'_'
.
$_FILES['image']['name'];

move_uploaded_file(

$_FILES['image']['tmp_name'],

'../assets/images/'
.
$imageName

);

}

/*
UPDATE MENU
*/

$sqlUpdate = "

UPDATE menus

SET

title = :title,

description = :description,

theme = :theme,

regime = :regime,

min_people = :min_people,

price = :price,

stock = :stock,

conditions = :conditions,

image = :image

WHERE id = :id

";

$queryUpdate =
$pdo->prepare(
$sqlUpdate
);

$queryUpdate->execute([

'title'
=>
$title,

'description'
=>
$description,

'theme'
=>
$theme,

'regime'
=>
$regime,

'min_people'
=>
$min_people,

'price'
=>
$price,

'stock'
=>
$stock,

'conditions'
=>
$conditions,

'image'
=>
$imageName,

'id'
=>
$id

]);

$message =
"Menu modifié avec succès";

/*
RAFRAICHIR
*/

$queryMenu->execute([

'id'
=>
$id

]);

$menu =
$queryMenu->fetch();

}

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

    <h1 class="mb-5">
        Modifier le menu
    </h1>

    <?php if ($message): ?>

        <div class="alert alert-success">

            <?= $message; ?>

        </div>

    <?php endif; ?>

    <div class="card p-4">

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">
                    Titre
                </label>

                <input 
                    type="text"
                    name="title"
                    class="form-control"
                    value="<?= $menu['title']; ?>"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Description
                </label>

                <textarea 
                    name="description"
                    class="form-control"
                    required
                ><?= $menu['description']; ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Thème
                </label>

                <input 
                    type="text"
                    name="theme"
                    class="form-control"
                    value="<?= $menu['theme']; ?>"
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Régime
                </label>

                <input 
                    type="text"
                    name="regime"
                    class="form-control"
                    value="<?= $menu['regime']; ?>"
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nombre minimum de personnes
                </label>

                <input 
                    type="number"
                    name="min_people"
                    class="form-control"
                    value="<?= $menu['min_people']; ?>"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Prix
                </label>

                <input 
                    type="number"
                    step="0.01"
                    name="price"
                    class="form-control"
                    value="<?= $menu['price']; ?>"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Stock
                </label>

                <input 
                    type="number"
                    name="stock"
                    class="form-control"
                    value="<?= $menu['stock']; ?>"
                    required
                >

            </div>

            <div class="mb-3">
                <div class="mb-3">

    <label class="form-label">
        Nouvelle image
    </label>

    <input 
        type="file"
        name="image"
        class="form-control"
    >

</div>

                <label class="form-label">
                    Conditions
                </label>

                <textarea 
                    name="conditions"
                    class="form-control"
                ><?= $menu['conditions']; ?></textarea>

            </div>

            <button class="btn btn-primary">

                Modifier le menu

            </button>

        </form>

    </div>

</section>

<?php include '../includes/footer.php'; ?>