<?php

// Load application
require('bootstrap.php');
$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function () use ($app) {
        return 'Welcome to the homepage';
    });

return $app;