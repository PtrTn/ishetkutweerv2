<?php

namespace Providers;

use JeroenDesloovere\Distance\Distance;
use Station\StationFactory;
use Station\StationFinder;
use Silex\Application;
use Silex\ServiceProviderInterface;

class StationServiceProvider implements ServiceProviderInterface
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
 