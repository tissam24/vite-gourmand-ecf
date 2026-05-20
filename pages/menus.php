<?php

include '../config/database.php';

$sql = "SELECT * FROM menus ORDER BY id DESC";

$query = $pdo->query($sql);

$menus = $query->fetchAll();

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

    <h1 class="mb-5">
        Nos Menus
    </h1>
<div class="container mb-5">

    <div class="card shadow border-0 p-4">

        <div class="row g-3">

            <div class="col-md-4">

                <select 
                    id="themeFilter"
                    class="form-select"
                >

                    <option value="">
                        Tous les thèmes
                    </option>

                    <option value="Italien">
                        Italien
                    </option>

                    <option value="Mexicain">
                        Mexicain
                    </option>

                    <option value="Oriental">
                        Oriental
                    </option>

                    <option value="Japonais">
                        Japonais
                    </option>
                    <option value="Evenement">
    Evenement
</option>

                </select>

            </div>

            <div class="col-md-4">

                <select 
                    id="regimeFilter"
                    class="form-select"
                >

                    <option value="">
                        Tous les régimes
                    </option>

                    <option value="Vegan">
                        Vegan
                    </option>

                    <option value="Vegetarien">
                        Vegetarien
                    </option>

                    <option value="Classique">
                        Classique
                    </option>

                </select>

            </div>

            <div class="col-md-4">

                <input
                    type="number"
                    id="priceFilter"
                    class="form-control"
                    placeholder="Prix maximum"
                >

            </div>
            <div class="col-md-4">

<input
type="number"
id="peopleFilter"
class="form-control"
placeholder="Nombre minimum de personnes"

>

</div>

        </div>

    </div>

</div>
    <div class="row">

        <?php foreach ($menus as $menu): ?>

            <div 
    class="col-md-4 mb-4 menu-card"
    data-theme="<?= $menu['theme']; ?>"
    data-regime="<?= $menu['regime']; ?>"
    data-price="<?= $menu['price']; ?>"
data-people="<?= $menu['min_people']; ?>"
>


                <div class="card h-100 shadow">
                    <?php if (!empty($menu['image'])) { ?>

    <img 
        src="../assets/images/<?= $menu['image']; ?>"
        class="card-img-top"
        style="height: 220px; object-fit: cover;"
    >

<?php } ?>

                    <div class="card-body">

                        <h3 class="card-title">
                            <?= $menu['title']; ?>
                        </h3>

                        <p class="card-text">
                            <?= $menu['description']; ?>
                        </p>

                        <p>
                            <strong>Thème :</strong>
                            <?= $menu['theme']; ?>
                        </p>

                        <p>
                            <strong>Régime :</strong>
                            <?= $menu['regime']; ?>
                        </p>

                        <p>
                            <strong>Prix :</strong>
                            <?= $menu['price']; ?> €
                        </p>

                        <p>
                            <strong>Minimum :</strong>
                            <?= $menu['min_people']; ?> personnes
                        </p>

                        <div class="d-flex gap-2">

<a 
href="order.php?menu_id=<?= $menu['id']; ?>"
class="btn btn-primary w-50"
>

Commander

</a>

<a
href="menu-details.php?id=<?= $menu['id']; ?>"
class="btn btn-outline-dark w-50"
>

Détails

</a>

</div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>
<script>

const themeFilter = document.getElementById('themeFilter');

const regimeFilter = document.getElementById('regimeFilter');

const priceFilter = document.getElementById('priceFilter');

const peopleFilter = document.getElementById('peopleFilter');

const menus = document.querySelectorAll('.menu-card');

function filterMenus() {

    const selectedTheme = themeFilter.value;

    const selectedRegime = regimeFilter.value;

    const selectedPrice = priceFilter.value;
    const selectedPeople = peopleFilter.value;

    menus.forEach(menu => {

        const theme = menu.dataset.theme;

        const regime = menu.dataset.regime;

        const price = parseFloat(menu.dataset.price);
        const people = parseInt(menu.dataset.people);

        let show = true;

        if (
            selectedTheme !== '' &&
            theme !== selectedTheme
        ) {

            show = false;

        }

        if (
            selectedRegime !== '' &&
            regime !== selectedRegime
        ) {

            show = false;

        }

        if (
            selectedPrice !== '' &&
            price > selectedPrice
        ) {

            show = false;

        }

        if (
            selectedPeople !== '' &&
            people < selectedPeople
        ) {

            show = false;

        }

        if (show) {

            menu.style.display = 'block';

        } else {

            menu.style.display = 'none';

        }

    });

}

themeFilter.addEventListener(
    'change',
    filterMenus
);

regimeFilter.addEventListener(
    'change',
    filterMenus
);

priceFilter.addEventListener(
    'input',
    filterMenus
);
peopleFilter.addEventListener(
    'input',
    filterMenus
);

</script>
<?php include '../includes/footer.php'; ?>