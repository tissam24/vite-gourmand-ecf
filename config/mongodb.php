<?php

$reviewsCollection = null;

if (is_file(__DIR__ . '/secrets.local.php')) {
    require __DIR__ . '/secrets.local.php';
}

require_once __DIR__ . '/../vendor/autoload.php';

if (class_exists('MongoDB\Client')) {

    try {

        $client = new MongoDB\Client(
            getenv('MONGO_URI') ?: 'mongodb://localhost:27017'
        );

        $mongoDatabase = $client->vite_gourmand_reviews;

        $reviewsCollection = $mongoDatabase->reviews;

    } catch (Exception $e) {

        $reviewsCollection = null;

    }

}
