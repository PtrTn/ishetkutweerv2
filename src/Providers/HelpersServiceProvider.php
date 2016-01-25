<?php

namespace Providers;

use Helpers\BackgroundController;
use Helpers\BeaufortCalculator;
use Helpers\RoutingController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class HelpersServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['beaufortCalculator'] = function () use ($app) {
            return new BeaufortCalculator();
        };
        $app['routingController'] = function () use ($app) {
            return new RoutingController();
        };
        $app['backgroundController'] = function () use ($app) {
            return new BackgroundController();
        };
    }

    public function boot(Application $app)
    {

    }
}
 