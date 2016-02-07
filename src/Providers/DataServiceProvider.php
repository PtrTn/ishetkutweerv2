<?php

namespace Providers;

use CurrentData\CurrentDataFactory;
use CurrentData\CurrentDataSource;
use HttpClients\FileGetContentsClient;
use Location\LocationDataFactory;
use Location\LocationDataSource;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DataServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['fileGetContentsClient'] = function () use ($app) {
            return new FileGetContentsClient();
        };

        // Location data
        $app['locationApiUrl'] = 'http://www.geoplugin.net/php.gp';
        $app['locationDataFactory'] = function () use ($app) {
            return new LocationDataFactory();
        };
        $app['locationDataSource'] = function () use ($app) {
            return new LocationDataSource($app['fileGetContentsClient'], $app['locationDataFactory'], $app['locationApiUrl']);
        };

        // Current data
        $app['currentApiUrl'] = 'http://xml.buienradar.nl/';
        $app['currentDataFactory'] = function () use ($app) {
            return new CurrentDataFactory();
        };
        $app['currentDataSource'] = function () use ($app) {
            return new CurrentDataSource($app['fileGetContentsClient'], $app['currentDataFactory'], $app['currentApiUrl']);
        };
    }

    public function boot(Application $app)
    {

    }
}
 