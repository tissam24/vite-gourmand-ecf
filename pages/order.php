<?php

session_start();

include '../config/database.php';

include '../config/mongodb.php';

include '../config/mail.php';


if (!isset($_SESSION['user'])) {
header("Location: login.php");
exit;
}

if (!isset($_GET['menu_id'])) {
die("Menu introuvable");
}

$menu_id = $_GET['menu_id'];

$sql =
"SELECT * FROM menus WHERE id=:id";

$query =
$pdo->prepare($sql);

$query->execute([
'id'=>$menu_id
]);

$menu =
$query->fetch();

if(!$menu){
die("Menu inexistant");
}

function estimateKm($address){

$text =
mb_strtolower($address);

if(str_contains($text,'bordeaux')){
return 0;
}

if(
str_contains($text,'mérignac')
||
str_contains($text,'merignac')
){
return 9;
}

if(str_contains($text,'pessac')){
return 8;
}

if(str_contains($text,'talence')){
return 5;
}

if(str_contains($text,'arcachon')){
return 65;
}

return 15;

}

if($_SERVER['REQUEST_METHOD']==='POST'){

$email =
$_POST['email'];

$phone =
$_POST['phone'];

$address =
$_POST['address'];

$date =
$_POST['event_date'];

$time =
$_POST['event_time'];

$people =
(int)
$_POST['people'];

$comment =
$_POST['comment'];

if(
$people
<
$menu['min_people']
){

die(
"Minimum : "
.
$menu['min_people']
.
" personnes"
);

}

$km =
estimateKm(
$address
);

$delivery =
0;

if(
$km>0
){

$delivery =
5
+
(
0.59
*
$km
);

}

$discount = 0;

if(
$people
>=
(
$menu['min_people']
+
5
)
){

$discount =
$menu['price']
*
0.10;

}

$total =
$menu['price']
+
$delivery
-
$discount;

$sqlOrder =

"

INSERT INTO orders(

user_id,
menu_id,
total_price,
email,
phone,
address,
event_date,
event_time,
comment,
people

)

VALUES(

:user_id,
:menu_id,
:total_price,
:email,
:phone,
:address,
:event_date,
:event_time,
:comment,
:people

)

";

$queryOrder =
$pdo->prepare(
$sqlOrder
);

$queryOrder->execute([

'user_id'=>
$_SESSION['user']['id'],

'menu_id'=>
$menu_id,

'total_price'=>
$total,

'email'=>
$email,

'phone'=>
$phone,

'address'=>
$address,

'event_date'=>
$date,

'event_time'=>
$time,

'comment'=>
$comment,

'people'=>
$people

]);

$orderId =
$pdo->lastInsertId();

$totalFormat =
number_format(
$total,
2,
',',
' '
);

$mailBody = "

<h2>
Commande confirmée ✅
</h2>

<p>
Bonjour ".$_SESSION['user']['firstname']."
</p>

<p>
Merci pour votre commande chez
<b>Vite & Gourmand</b>.
</p>

<hr>

<p>
Numéro commande :
<b>#".$orderId."</b>
</p>

<p>
Montant :
<b>".$totalFormat." €</b>
</p>

<p>
Date événement :
".$date."
</p>

<p>
Heure livraison :
".$time."
</p>

<p>
Adresse :
".$address."
</p>

<hr>

<p>
Votre commande est confirmée
et en préparation.
</p>

";

sendMail(
$email,
'Confirmation commande',
$mailBody
);

$orderStats =
$mongoDatabase
->order_stats;

$orderStats
->insertOne([

'menu'=>
$menu['title'],

'menu_id'=>
(int)$menu_id,

'price'=>
(float)$total,

'created_at'=>
date(
'Y-m-d H:i:s'
)

]);

$success=true;

}

?>

<?php include '../includes/header.php'; ?>

<section class="container mt-5">

<?php if(isset($success)){ ?>

<div class="alert alert-success">

Commande enregistrée 🎉

</div>

<?php } ?>

<div class="card shadow p-5">

<h2 class="text-center mb-5">

Commander :

<?= $menu['title']; ?>

</h2>

<form method="POST">

<label>

Nom

</label>

<input
class="form-control mb-3"
value="<?= $_SESSION['user']['lastname']; ?>"
readonly
>

<label>

Prénom

</label>

<input
class="form-control mb-3"
value="<?= $_SESSION['user']['firstname']; ?>"
readonly
>

<label>

Email

</label>

<input
type="email"
name="email"
class="form-control mb-3"
value="<?= $_SESSION['user']['email']; ?>"
readonly
>

<label>

Téléphone

</label>

<input
type="text"
name="phone"
class="form-control mb-3"
value="<?= $_SESSION['user']['telephone'] ?? ''; ?>"
required
>

<label>

Adresse prestation

</label>

<textarea
name="address"
id="address"
class="form-control mb-3"
required
></textarea>

<label>

Date événement

</label>

<input
type="date"
name="event_date"
class="form-control mb-3"
required
>

<label>

Heure livraison

</label>

<input
type="time"
name="event_time"
class="form-control mb-3"
required
>

<label>

Nombre personnes

</label>

<input
type="number"
name="people"
id="people"
min="<?= $menu['min_people']; ?>"
value="<?= $menu['min_people']; ?>"
class="form-control"
required
>

<small>

Minimum :

<?= $menu['min_people']; ?>

</small>

<label class="mt-3">

Commentaire

</label>

<textarea
name="comment"
class="form-control"
rows="3"
></textarea>

<div
id="preview"
class="alert alert-warning mt-4"
></div>

<button
class="btn btn-primary w-100"
>

Valider la commande

</button>

</form>

</div>

</section>

<script>

const address =
document.getElementById(
'address'
);

const people =
document.getElementById(
'people'
);

const preview =
document.getElementById(
'preview'
);

const menu =
<?= $menu['price']; ?>;

const min =
<?= $menu['min_people']; ?>;

function km(){

const txt =
address.value
.trim()
.toLowerCase();

if(
txt === ''
){

return null;

}

if(
txt.includes(
'bordeaux'
)
){
return 0;
}

if(
txt.includes(
'merignac'
)
||
txt.includes(
'mérignac'
)
){
return 9;
}

if(
txt.includes(
'pessac'
)
){
return 8;
}

if(
txt.includes(
'talence'
)
){
return 5;
}

if(
txt.includes(
'arcachon'
)
){
return 65;
}

return 15;

}

function calc(){

const distance =
km();

if(
distance===null
){

preview.innerHTML=`

<h5>

Récapitulatif du prix

</h5>

Prix menu :
${menu.toFixed(2)} €

<br>

Saisissez une adresse pour calculer la livraison.

`;

return;

}

let livraison =
distance>0
?
5+(distance*0.59)
:
0;

let reduction =

Number(
people.value
)

>=

(
min+5
)

?

menu
*
0.10

:

0;

let total =

menu
+
livraison
-
reduction;

preview.innerHTML=

`

<h5>

Récapitulatif du prix

</h5>

Prix menu :
${menu.toFixed(2)} €

<br>

Distance :
${distance} km

<br>

Livraison :
${livraison.toFixed(2)} €

<br>

Réduction :
-${reduction.toFixed(2)} €

<hr>

<strong>

Total :
${total.toFixed(2)} €

</strong>

`;

}

address.addEventListener(
'input',
calc
);

people.addEventListener(
'input',
calc
);

calc();

</script>

<?php include '../includes/footer.php'; ?>