<?php

require_once __DIR__.'/../vendor/autoload.php';

try{

$client =
new MongoDB\Client(
"mongodb+srv://..."
);

$mongoDatabase =
$client->vite_gourmand_reviews;

$reviewsCollection =
$mongoDatabase->reviews;

}

catch(Exception $e){

$reviewsCollection = null;

}