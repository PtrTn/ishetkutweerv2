<?php

namespace Providers;

use ForecastData\ForecastDataProvider;
use HistoricData\HistoricDataProvider;
use HttpClients\FileGetContentsClient;
use HttpClients\FileGetContentsHttpClient;
use Location\LocationDataFactory;
use Location\LocationDataManager;
use Location\LocationDataSource;
use PresentData\PresentDataProvider;
use RainData\RainDataProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;
use VertigoLabs\Overcast\Overcast;

class DataServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        // TODO move to config file
        $app['locationApiUrl'] = 'http://www.geoplugin.net/php.gp';
        $app['fileGetContentsClient'] = function () use ($app) {
            return new FileGetContentsClient();
        };
        $app['locationDataFactory'] = function () use ($app) {
            return new LocationDataFactory();
        };
        $app['locationDataSource'] = function () use ($app) {
            return new LocationDataSource($app['fileGetContentsClient'], $app['locationDataFactory'], $app['locationApiUrl']);
        };
    }

    public function boot(Application $app)
    {

    }

}
 