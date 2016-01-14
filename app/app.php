<?php

date_default_timezone_set('Europe/Amsterdam');
// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/resources/views',
));

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
$dis = new JeroenDesloovere\Distance\Distance;

$date = date('md');
$result = $app['db']->fetchAll("SELECT * FROM weatherdata WHERE date LIKE ? ORDER BY date", array('%' . $date));
//var_dump($date);
//var_dump($result);

// Set homepage
$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig');
});


$app['locator'] = function () use ($app) {
    return new \Location\Locator();
};
$app['distanceCalc'] = function () {
    return new JeroenDesloovere\Distance\Distance;
};
$app['stationFactory'] = function () use ($app) {
    return new \Location\StationFactory();
};
$app['stationFinder'] = function () use ($app) {
    return new \Location\StationFinder($app['stationFactory'], $app['distanceCalc']);
};
$app['presentDataProvider'] = function () use ($app) {
    return new \DataProviding\PresentDataProvider();
};
$app['historicDataProvider'] = function () use ($app) {
    return new \DataProviding\HistoricDataProvider($app['db']);
};

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

var_dump($station);
var_dump($presentData);
var_dump($historicData);

// TODO Gegevens verwerken (rating geven etc)

// TODO Gegevens formatten voor weergaven

return $app;