<?php

namespace Providers;

use DataProviding\HistoricDataProvider;
use DataProviding\PresentDataProvider;
use DataProviding\PresentMessageProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DataProvidingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['presentDataProvider'] = function () {
            return new PresentDataProvider();
        };
        $app['presentMessageProvider'] = function () {
            return new PresentMessageProvider();
        };
        $app['historicDataProvider'] = function () use ($app) {
            return new HistoricDataProvider($app['db']);
        };
    }

    public function boot(Application $app)
    {

    }

}
 