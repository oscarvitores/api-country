<?php

require '../vendor/autoload.php';

// Prepare app
$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

// Define routes
$app->get('/api', function () use ($app) {
    echo json_encode(array("key" => "value"));
});

// Run app
$app->run();
