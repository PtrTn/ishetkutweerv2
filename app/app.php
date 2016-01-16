<?php

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

// Load config file
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/config/config.yaml'));

// Get database config based on env
$databaseConfig = $app['config']['prod']['database'];
if ($app['debug'] === true) {
    $databaseConfig = $app['config']['dev']['database'];
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
$app->register(new \Providers\LocationServiceProvider());
$app->register(new \Providers\DataProvidingServiceProvider());
$app->register(new \Providers\RatingServiceProvider());

// Get IP using connection details
$ip = $_SERVER['REMOTE_ADDR'];
if ($app['debug'] === true) {
    $ip = '213.34.236.130';
}

// Get location based on IP
$location = $app['locator']->getLocation($ip);

// Get station based on location
$station = $app['stationFinder']->findStation($location);

// Get data based on station
$presentData = $app['presentDataProvider']->getDataByStation($station);
$historicData = $app['historicDataProvider']->getDataByStation($station);
$messages = $app['presentMessageProvider']->getData();
$forecastData = $app['forecastDataProvider']->getDataByStation($station);

// Rate current weather based on historical data and other rules
$rating = $app['ratingCalculator']->getRating($presentData, $historicData);

// Render page using found data
$app->get('/', function () use ($app, $station, $rating, $messages, $presentData, $forecastData) {
    return $app['twig']->render('home.twig', [
        'station' => $station,
        'rating' => $rating,
        'messages' => $messages,
        'presentData' => $presentData,
        'forecastData' => $forecastData
    ]);
});

// TODO add gulp css compiling
// TODO add long message as 'meer' option
// TODO add 'meer' forecast
// TODO windkracht in beaufort
// TODO make php 5.4 compatible
// TODO hover tooltip with historic averages (normaal is het .. )

// TODO add open graph & twitter card implementation
// TODO add daily social media posts
// TODO weather-dependant background image
// TODO allow location changing
// TODO add javascript location precision
// TODO better rating calculation
// TODO cool measurement icons
// TODO weather alerts
// TODO extend collection class?

return $app;