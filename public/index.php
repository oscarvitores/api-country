<?php

require __DIR__ . '/../vendor/autoload.php';

use Api\Country\Controller\CountryController;
use Api\Country\Model\CountryManager;
use Api\Country\Model\RestFormatter;

// Prepare app
$app = new Slim\Slim();

// Config
$properties = parse_ini_file(__DIR__ . "/../app/properties.ini");
if (empty($properties)) {
    $properties = parse_ini_file(__DIR__ . "/../app/properties.ini.dist");
}
if (!isset($properties["db.options"])) {
    $properties["db.options"] = null;
}

$app->properties = $properties;

// DI container
$app->container->singleton('dba', function($container) {
    $properties = $container->get('properties');

    return new PDO($properties["db.dsn"], $properties["db.username"], $properties['db.password'], $properties["db.options"]);
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
