<?php

namespace Providers;

use DataProviding\HistoricDataProvider;
use DataProviding\PresentDataProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class LocationServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['presentDataProvider'] = function () use ($app) {
            return new PresentDataProvider();
        };
        $app['historicDataProvider'] = function () use ($app) {
            return new HistoricDataProvider($app['db']);
        };
    }

    public function boot(Application $app)
    {

    }
}
 