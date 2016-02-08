<?php

namespace Providers;

use Controllers\BackgroundController;
use Controllers\RoutingController;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
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
 