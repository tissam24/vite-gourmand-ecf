<?php

require_once __DIR__ . '/../vendor/autoload.php';

$client = new MongoDB\Client(
    "mongodb+srv://admin:Tissam.2410@cluster0.1e8h3n4.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"
);

$mongoDatabase = $client->vite_gourmand_reviews;

$reviewsCollection = $mongoDatabase->reviews;