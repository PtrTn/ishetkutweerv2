<?php

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__ . '/Resources/views',
    ));

// Routing
$app->get('/', function () use ($app) {
        return $app['twig']->render('home.twig');
    });

/* ----- IpInfoDb ApiClient ----- */
$app['ipinfodb_config'] = __DIR__ . '/config/ipinfodb.yml.dist';
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

/* ----- Wunderground ApiClient ----- */
$app['wunderground_config'] = __DIR__ . '/config/wunderground.yml.dist';
$app['wunderground_config_parser'] = function() use ($app) {
    return new \Importing\YamlImporter($app['wunderground_config']);
};
$app['wunderground_apiclient'] = function() use ($app) {
    return new \WeatherManagement\WundergroundApiClient($app['wunderground_config_parser']->getData());
};
$app['weather_manager'] = function() use ($app) {
    return new \WeatherManagement\WeatherManager($app['wunderground_apiclient'], $app['location_manager']);
};

$app->get('/weather', function () use ($app) {
        return $app->json($app['weather_manager']->getWeather());
    });

return $app;