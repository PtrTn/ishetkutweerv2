<?php

namespace Providers;

use Controllers\BackgroundController;
use Controllers\DataController;
use Controllers\RoutingController;
use Controllers\ViewController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['viewController'] = function () use ($app) {
            return new ViewController($app);
        };
        $app['routingController'] = function () use ($app) {
            return new RoutingController($app['viewController'], $app['stationFinder'], $app['locationDataSource']);
        };
        $app['backgroundController'] = function () use ($app) {
            return new BackgroundController();
        };
    }

    public function boot(Application $app)
    {

    }
}
 