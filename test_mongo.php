<?php

include 'config/mongodb.php';

$reviews=
$reviewsCollection
->find([

'status'=>
'validated'

]);

foreach ($reviews as $review) {

    echo "<h3>" . $review['user'] . "</h3>";

    echo "<p>" . $review['comment'] . "</p>";

    echo "<hr>";
}