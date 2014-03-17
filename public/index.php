<?php

require '../vendor/autoload.php';

// Prepare app
$app = new \Slim\Slim();

$app->container->singleton('country-manager', function() {
    return new Api\Country\Model\CountryManager(new PDO("mysql:dbname=api_country;host=localhost", "root"));
});

$app->container->singleton('rest-formatter', function() {
    return new Api\Country\Model\RestFormatter();
});

// Route configuration
$app->get('/api/countries', function() use ($app) {
    CountryController::listCountriesAction($app);
});

// Run app
$app->run();
