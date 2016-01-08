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
$app->register(new DerAlex\Silex\YamlConfigServiceProvider( __DIR__ . '/config/config.yaml'));

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
        'driver'   => $databaseConfig['driver']
    ),
));

$date = date('md');
$result = $app['db']->fetchAll("SELECT * FROM weatherdata WHERE date LIKE ? ORDER BY date", ['%' . $date]);
var_dump($date);
var_dump($result);

// Set homepage
$app->get('/', function () use ($app) {
        return $app['twig']->render('home.twig');
    });

// Locatie omzetten naar weerstation

// Gegevens van weerstation ophalen

// Gegevens verwerken (rating geven etc)

// Gegevens formatten voor weergaven

return $app;