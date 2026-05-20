<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

include '../config/database.php';

$status =
$_GET['status']
?? '';

$search =
$_GET['search']
?? '';

$sql =

"

SELECT

orders.*,

users.firstname,

users.lastname

FROM orders

LEFT JOIN users

ON users.id=
orders.user_id

WHERE 1=1

";

$params=[];

if(
$status!=''
){

$sql.=

"

AND orders.status=?

";

$params[]=
$status;

}

if(
$search!=''
){

$sql.=

"

AND(

users.firstname ILIKE ?

OR

users.lastname ILIKE ?

)

";

$params[]=
"%".$search."%";

$params[]=
"%".$search."%";

}

$sql.=

"

ORDER BY orders.id DESC

";

$query=
$pdo->prepare(
$sql
);

$query->execute(
$params
);

$orders=
$query->fetchAll();

if (!isset($_SESSION['user'])) {

    header("Location: ../pages/login.php");
    exit;
}

/*
Vérification admin
role_id = 3
*/

if(
$_SESSION['user']['role_id']
!=3
){

die(
"Accès refusé"
);

}

$sql = "

SELECT

orders.id,

orders.status,

orders.total_price,

orders.created_at,

users.firstname,

users.lastname,

menus.title

FROM orders

INNER JOIN users
ON orders.user_id=users.id

INNER JOIN menus
ON orders.menu_id=menus.id

WHERE 1=1

";

$params=[];

if($status!=''){

$sql.=" AND orders.status=? ";

$params[]=$status;

}

if($search!=''){

$sql.="

AND(

users.firstname ILIKE ?

OR

users.lastname ILIKE ?

)

";

$params[]="%".$search."%";

$params[]="%".$search."%";

}

$sql.="

ORDER BY orders.created_at DESC

";

$query=
$pdo->prepare($sql);

$query->execute($params);

$orders=
$query->fetchAll();

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

    <h1 class="mb-5">
        Dashboard Administrateur
    </h1>
   <div class="card p-3 mb-4">

<h4>
Gestion des employés
</h4>

<a
href="create_employee.php"
class="btn btn-success me-2">

Créer un employé

</a>

<a
href="employee.php"
class="btn btn-danger">

Gérer les employés

</a>
<a
href="stats.php"
class="btn btn-dark">

Statistiques

</a>
<a
href="revenue.php"
class="btn btn-warning">

Chiffre d'affaires

</a>

</div>

<form
method="GET"
class="row mb-4"
>

<div class="col-md-4">

<select
name="status"
class="form-select"
>

<option value="">

Tous statuts

</option>

<option value="En attente">

En attente

</option>

<option value="Validée">

Validée

</option>

<option value="Préparation">

Préparation

</option>

<option value="Livrée">

Livrée

</option>

</select>

</div>

<div class="col-md-5">

<input

type="text"

name="search"

class="form-control"

placeholder="Nom client"

value="<?= $search ?>"

>

</div>

<div class="col-md-3">

<button
class="btn btn-warning w-100"
>

Filtrer

</button>

</div>

</form>

    <?php if (count($orders) > 0): ?>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Client</th>
                    <th>Menu</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($orders as $order): ?>

                    <tr>

                        <td>
                            <?= $order['id']; ?>
                        </td>

                        <td>
                            <?= $order['firstname']; ?>
                            <?= $order['lastname']; ?>
                        </td>

                        <td>
                            <?= $order['title']; ?>
                        </td>

                        <td>
    <?= $order['total_price']; ?> €
</td>

<td>

    <?php if ($order['status'] == 'En attente') { ?>

        <span class="badge bg-warning text-dark">
            En attente
        </span>

    <?php } elseif ($order['status'] == 'Validée') { ?>

        <span class="badge bg-success">
            Validée
        </span>

    <?php } elseif ($order['status'] == 'Préparation') { ?>

        <span class="badge bg-primary">
            Préparation
        </span>

    <?php } elseif ($order['status'] == 'Livrée') { ?>

        <span class="badge bg-dark">
            Livrée
        </span>

    <?php } ?>

</td>

                        <td>
                            <?= $order['created_at']; ?>
                        </td>
                        <td>

    <form method="POST" action="/admin/update_order_status.php">

        <input 
            type="hidden"
            name="order_id"
            value="<?= $order['id']; ?>"
        >

        <select 
            name="status"
            class="form-select mb-2"
        >

            <option value="En attente">
                En attente
            </option>

            <option value="Validée">
                Validée
            </option>

            <option value="Préparation">
                Préparation
            </option>

            <option value="Livrée">
                Livrée
            </option>

        </select>

        <button class="btn btn-primary btn-sm w-100">

            Modifier

        </button>

    </form>

</td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php else: ?>

        <div class="alert alert-info">

            Aucune commande trouvée.

        </div>

    <?php endif; ?>

</section>

<?php include '../includes/footer.php'; ?>