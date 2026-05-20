<?php

session_start();

include '../config/mongodb.php';

$collection =
$mongoDatabase
->order_stats;

$data =
$collection
->aggregate([

[

'$group'=>[

'_id'=>'$menu',

'total'=>[

'$sum'=>1

]

]

]

]);

$labels=[];

$values=[];

foreach(
$data
as
$item
){

$labels[]=
$item['_id'];

$values[]=
$item['total'];

}

?>

<?php include '../includes/header.php'; ?>

<section
class="container mt-5"
>

<h1>

Commandes par menu

</h1>

<canvas
id="chart"
></canvas>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(

document
.getElementById(
'chart'
),

{

type:'bar',

data:{

labels:

<?= json_encode($labels); ?>,

datasets:[{

label:

'Nombre commandes',

data:

<?= json_encode($values); ?>

}]

}

}

);

</script>

<?php include '../includes/footer.php'; ?>