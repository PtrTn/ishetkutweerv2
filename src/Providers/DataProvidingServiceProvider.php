<?php

namespace Providers;

use ForecastData\ForecastDataProvider;
use HistoricData\HistoricDataProvider;
use PresentData\PresentDataProvider;
use PresentData\PresentMessageProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;
use VertigoLabs\Overcast\Overcast;

class DataProvidingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['presentDataProvider'] = function () use ($app) {
            return new PresentDataProvider($app['beaufortCalculator'], $app['stationFinder']);
        };
        $app['historicDataProvider'] = function () use ($app) {
            return new HistoricDataProvider($app['db'], $app['beaufortCalculator'], $app['stationFinder']);
        };

        // Get Forecast.io api key
        $forecastApiKey = $app['config']['prod']['api']['forecast'];
        if ($app['debug'] === true) {
            $forecastApiKey = $app['config']['dev']['api']['forecast'];
        }
        $app['overcast'] = function () use ($forecastApiKey) {
            return new Overcast($forecastApiKey);
        };
        $app['forecastDataProvider'] = function () use ($app) {
            return new ForecastDataProvider($app['overcast'], $app['beaufortCalculator']);
        };
    }

    public function boot(Application $app)
    {

    }

}
 