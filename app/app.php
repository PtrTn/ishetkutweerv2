<?php

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

// Routing
$app->get('/', function () use ($app) {
        return 'Welcome to the homepage';
    });

// Setup variables
$app['ipinfodb_config'] = __DIR__ . '/config/ipinfodb.yml.dist';

// Setup injection containers
$app['ipinfodb_config_parser'] = function() use ($app) {
    return new \Importing\YamlImporter($app['ipinfodb_config']);
};

$app['ipinfodb_apiclient'] = function() use ($app) {
    return new \LocationManagement\IpinfodbApiClient($app['ipinfodb_config_parser']->getData());
};

$app['location_manager'] = function () use ($app) {
    return new \LocationManagement\LocationManager($app['ipinfodb_apiclient']);
};

$app->get('/location', function () use ($app) {
        return $app->json($app['location_manager']->getLocation());
    });

return $app;