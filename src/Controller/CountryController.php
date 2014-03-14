<?php

namespace Api\Country\Controller;

/**
 */
class CountryController
{

    public static $listCountriesAction;

}

CountryController::$listCountriesAction = function() {
    $app = \Slim\Slim::getInstance();

    $countryManager = $app->container->get('country-manager');
    $listCountries  = $countryManager->listAll();

    $formatter = $app->container->get('rest-formatter');

    $app->response->headers->set('Content-Type', 'application/json');
    echo $formatter->generateContentData($listCountries->fetchAll());
};
