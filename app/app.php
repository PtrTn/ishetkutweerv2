<?php

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = false;

// Load config file
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/config/config.yaml'));

// Get database config based on env
$app['env'] = $app['config']['env'];
$databaseConfig = $app['config'][$app['env']]['database'];
if($app['env'] === 'dev') {
    $app['debug'] = true;
}

// Setup database
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'dbname' => $databaseConfig['name'],
        'user' => $databaseConfig['user'],
        'password' => $databaseConfig['password'],
        'host' => $databaseConfig['host'],
        'driver' => $databaseConfig['driver']
    ),
));

// Setup views
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/resources/views',
));

// Define service providers
$app->register(new \Providers\HelpersServiceProvider());
$app->register(new \Providers\LocationServiceProvider());
$app->register(new \Providers\DataProvidingServiceProvider());
$app->register(new \Providers\RatingServiceProvider());

// Get IP using connection details
$ip = $_SERVER['REMOTE_ADDR'];
if ($ip === '127.0.0.1') {
    $ip = '213.34.236.130';
}

// Get location based on IP
$location = $app['locationDataProvider']->getLocation($ip);

// Get station based on location
$station = $app['stationFinder']->findStation($location);

// Get data based on station
$presentData = $app['presentDataProvider']->getDataByStation($station);
$historicData = $app['historicDataProvider']->getDataByStation($station);
$forecastData = $app['forecastDataProvider']->getDataByStation($station);

// Rate current weather based on historical data and other rules
$rating = $app['ratingCalculator']->getRating($presentData, $historicData);

// Render page using found data
$app->get('/', function () use ($app, $station, $rating, $historicData, $presentData, $forecastData) {
    return $app['twig']->render('home.twig', [
        'station' => $station,
        'rating' => $rating,
        'historicData' => $historicData,
        'presentData' => $presentData,
        'forecastData' => $forecastData
    ]);
});


return $app;