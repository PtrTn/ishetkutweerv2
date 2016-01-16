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

$rating = $app['ratingCalculator']->getRating($presentData, $historicData);

//var_dump($station);
//var_dump($messages);
var_dump($rating);
var_dump($presentData);
var_dump($historicData);

$app->get('/', function () use ($app, $station, $messages, $presentData) {
    return $app['twig']->render('home.twig', [
        'station' => $station,
        'messages' => $messages,
        'data' => $presentData
    ]);
});

return $app;