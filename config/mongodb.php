<?php

$reviewsCollection = null;

if(
class_exists('MongoDB\Client')
){

try{

require_once __DIR__.'/../vendor/autoload.php';

$client =
new MongoDB\Client(
getenv('MONGO_URI')
);

$mongoDatabase =
$client->vite_gourmand_reviews;

$reviewsCollection =
$mongoDatabase->reviews;

}

catch(Exception $e){

$reviewsCollection=null;

}

}