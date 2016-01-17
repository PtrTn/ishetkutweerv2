<?php

namespace Providers;

use Helpers\BeaufortCalculator;
use Silex\Application;
use Silex\ServiceProviderInterface;

class HelpersServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['beaufortCalculator'] = function () use ($app) {
            return new BeaufortCalculator();
        };
    }

    public function boot(Application $app)
    {

    }
}
 