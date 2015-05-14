<?php

date_default_timezone_set('Europe/Amsterdam');

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__ . '/resources/views',
    ));

// Set homepage
$app->get('/', function () use ($app) {
        return $app['twig']->render('home.twig');
    });

$app['api_client_factory'] = function () use ($app) {
    return new \ApiManagement\ApiClientFactory();
};

$app['day_factory'] = function () use ($app) {
    return new \WeatherManagement\WundergroundDayFactory();
};

$app['weather_manager'] = function() use ($app) {
    return new \WeatherManagement\WeatherManager($app['api_client_factory'], $app['day_factory']);
};

$app['api_data_provider'] = function() use ($app) {
    return new \ApiManagement\ApiDataProvider($app['weather_manager']);
};

// Setup internal API endpoints
$app->mount('/api', new \Routing\ApiControllerProvider($app['api_data_provider']));

return $app;