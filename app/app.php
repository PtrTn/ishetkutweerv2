<?php

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__ . '/Resources/views',
    ));

// Set homepage
$app->get('/', function () use ($app) {
        return $app['twig']->render('home.twig');
    });

$app['api_client_factory'] = function () use ($app) {
    return new \ApiManagement\ApiClientFactory();
};

$app['weather_manager'] = function() use ($app) {
    return new \WeatherManagement\WeatherManager($app['api_client_factory']);
};

// Setup internal API endpoints
$app->mount('/api', new \Routing\ApiControllerProvider());

return $app;