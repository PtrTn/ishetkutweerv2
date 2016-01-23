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
if ($app['env'] === 'dev') {
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

$app->get('/{slug}', function ($slug) use ($app) {
    return $app['routingController']->getDataBySlug($slug, $app);
});
$app->get('/', function () use ($app) {
    return $app['routingController']->getDataByIp($app);
});

return $app;