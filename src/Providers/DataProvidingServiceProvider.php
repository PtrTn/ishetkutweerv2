<?php

namespace Providers;

use DataProviding\ForecastDataProvider;
use DataProviding\HistoricDataProvider;
use DataProviding\PresentDataProvider;
use DataProviding\PresentMessageProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;
use VertigoLabs\Overcast\Overcast;

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

        // Get Forecast.io api key
        $forecastApiKey = $app['config']['prod']['api']['forecast'];
        if ($app['debug'] === true) {
            $forecastApiKey = $app['config']['dev']['api']['forecast'];
        }
        $app['overcast'] = function () use ($forecastApiKey) {
            return new Overcast($forecastApiKey);
        };
        $app['forecastDataProvider'] = function () use ($app) {
            return new ForecastDataProvider($app['overcast']);
        };
    }

    public function boot(Application $app)
    {

    }

}
 