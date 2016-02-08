<?php

namespace Providers;

use PresentData\PresentDataFactory;
use PresentData\PresentDataSource;
use ForecastData\ForecastDataFactory;
use ForecastData\ForecastDataSource;
use HistoricData\HistoryDataFactory;
use HistoricData\HistoryDataSource;
use HttpClients\FileGetContentsClient;
use Location\LocationDataFactory;
use Location\LocationDataSource;
use RainData\RainDataFactory;
use RainData\RainDataSource;
use Silex\Application;
use Silex\ServiceProviderInterface;
use VertigoLabs\Overcast\Overcast;

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
            return new LocationDataSource($app['locationDataFactory'], $app['fileGetContentsClient'], $app['locationApiUrl']);
        };

        // Current data
        $app['presentApiUrl'] = 'http://xml.buienradar.nl/';
        $app['presentDataFactory'] = function () {
            return new PresentDataFactory();
        };
        $app['presentDataSource'] = function () use ($app) {
            return new PresentDataSource($app['presentDataFactory'], $app['fileGetContentsClient'], $app['presentApiUrl']);
        };

        // Historic data
        $app['historyDataFactory'] = function () {
            return new HistoryDataFactory();
        };
        $app['historyDataSource'] = function () use ($app) {
            return new HistoryDataSource($app['historyDataFactory'], $app['db']);
        };

        // Forecast data
        $forecastApiKey = $app['config']['prod']['api']['forecast'];
        if ($app['debug'] === true) {
            $forecastApiKey = $app['config']['dev']['api']['forecast'];
        }
        $app['overcast'] = function () use ($forecastApiKey) {
            return new Overcast($forecastApiKey);
        };
        $app['forecastDataFactory'] = function () {
            return new ForecastDataFactory();
        };
        $app['forecastDataSource'] = function () use ($app) {
            return new ForecastDataSource($app['forecastDataFactory'], $app['overcast']);
        };

        // Rain Data
        $app['rainDataUrl'] = 'http://gps.buienradar.nl/getrr.php';
        $app['rainDataFactory'] = function () {
            return new RainDataFactory();
        };
        $app['rainDataSource'] = function () use ($app) {
            return new RainDataSource($app['rainDataFactory'], $app['fileGetContentsClient'], $app['rainDataUrl']);
        };
    }

    public function boot(Application $app)
    {

    }
}
 