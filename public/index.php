<?php

require '../vendor/autoload.php';

use Api\Country\Controller\CountryController;
use Api\Country\Model\CountryManager;
use Api\Country\Model\RestFormatter;

// Prepare app
$app = new Slim\Slim();

// DI container
$app->container->singleton('dba', function() {
    return new PDO("mysql:dbname=api_country;host=localhost", "root");
});

$app->container->singleton('country-manager', function($container) {
    return new CountryManager($container->get('dba'));
});

$app->container->singleton('rest-formatter', function() {
    return new RestFormatter();
});

// Route configuration
$app->get('/api/countries', function() use ($app) {
    CountryController::listCountriesAction($app);
});

// Run app
$app->run();
