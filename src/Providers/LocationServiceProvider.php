<?php

namespace Providers;

use JeroenDesloovere\Distance\Distance;
use Location\LocationDataProvider;
use Location\StationFactory;
use Location\StationFinder;
use Silex\Application;
use Silex\ServiceProviderInterface;

class LocationServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['distanceCalc'] = function () {
            return new Distance();
        };
        $app['stationFactory'] = function () use ($app) {
            return new StationFactory();
        };
        $app['stationFinder'] = function () use ($app) {
            return new StationFinder($app['stationFactory'], $app['distanceCalc']);
        };
    }

    public function boot(Application $app)
    {

    }
}
 