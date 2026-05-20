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

/*
AJOUT MENU
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

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {

        $imageName = time() . '_' . $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            '../assets/images/' . $imageName
        );
    }

    $sqlInsert = "
    INSERT INTO menus
    (title, description, theme, regime, min_people, price, stock, conditions, image)

    VALUES

    (:title, :description, :theme, :regime, :min_people, :price, :stock, :conditions, :image)
    ";

    $queryInsert = $pdo->prepare($sqlInsert);

    $queryInsert->execute([

        'title' => $title,
        'description' => $description,
        'theme' => $theme,
        'regime' => $regime,
        'min_people' => $min_people,
        'price' => $price,
        'stock' => $stock,
        'conditions' => $conditions,
        'image' => $imageName

    ]);

    $message = "Menu ajouté avec succès";
}

/*
AFFICHAGE MENUS
*/

$sqlMenus = "SELECT * FROM menus ORDER BY id DESC";

$queryMenus = $pdo->query($sqlMenus);

$menus = $queryMenus->fetchAll();

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

    <h1 class="mb-5">
        Gestion des menus
    </h1>

    <?php if ($message): ?>

        <div class="alert alert-success">

            <?= $message; ?>

        </div>

    <?php endif; ?>

    <div class="card p-4 mb-5">

        <h3 class="mb-4">
            Ajouter un menu
        </h3>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <div class="mb-3">

    <label class="form-label">
        Image du menu
    </label>

    <input 
        type="file"
        name="image"
        class="form-control"
    >

</div>

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
                    Description
                </label>

                <textarea 
                    name="description"
                    class="form-control"
                    required
                ></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Thème
                </label>

                <input 
                    type="text"
                    name="theme"
                    class="form-control"
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
                    required
                >

            </div>

            <div class="mb-3">
                <div class="mb-3">

    <label class="form-label">
        Image du menu
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
                ></textarea>

            </div>

            <button class="btn btn-success">

                Ajouter le menu

            </button>

        </form>

    </div>

    <h3 class="mb-4">
        Menus existants
    </h3>

    <table class="table table-bordered">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Titre</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($menus as $menu): ?>

                <tr>

                    <td>
                        <?= $menu['id']; ?>
                    </td>

                    <td>
                        <?= $menu['title']; ?>
                    </td>

                    <td>
                        <?= $menu['price']; ?> €
                    </td>

                    <td>
                        <?= $menu['stock']; ?>
                    </td>
                    <td>

    <a 
        href="/admin/edit_menu.php?id=<?= $menu['id']; ?>"
        class="btn btn-primary btn-sm"
    >
        Modifier
    </a>

    <a 
        href="/admin/delete_menu.php?id=<?= $menu['id']; ?>"
        class="btn btn-danger btn-sm"
        onclick="return confirm('Supprimer ce menu ?')"
    >
        Supprimer
    </a>

</td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</section>

<?php include '../includes/footer.php'; ?>