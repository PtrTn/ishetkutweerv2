<?php

namespace Providers;

use CurrentData\CurrentDataFactory;
use CurrentData\CurrentDataSource;
use HistoricData\HistoryDataFactory;
use HistoricData\HistoryDataSource;
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
        $app['locationDataFactory'] = function () {
            return new LocationDataFactory();
        };
        $app['locationDataSource'] = function () use ($app) {
            return new LocationDataSource($app['fileGetContentsClient'], $app['locationDataFactory'], $app['locationApiUrl']);
        };

        // Current data
        $app['currentApiUrl'] = 'http://xml.buienradar.nl/';
        $app['currentDataFactory'] = function () {
            return new CurrentDataFactory();
        };
        $app['currentDataSource'] = function () use ($app) {
            return new CurrentDataSource($app['fileGetContentsClient'], $app['currentDataFactory'], $app['currentApiUrl']);
        };

        // Historic data
        $app['historyDataFactory'] = function () {
            return new HistoryDataFactory();
        };
        $app['historyDataSource'] = function () use ($app) {
            return new HistoryDataSource($app['db'], $app['historyDataFactory']);
        };
    }

    public function boot(Application $app)
    {

    }
}
 