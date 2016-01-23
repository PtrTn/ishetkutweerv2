<?php

namespace Providers;

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
    }

    public function boot(Application $app)
    {

    }
}
 