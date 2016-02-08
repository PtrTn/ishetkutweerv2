<?php

namespace Providers;

use RainData\RainDataProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DataProvidingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['rainDataProvider'] = function () use ($app) {
            return new RainDataProvider();
        };
    }

    public function boot(Application $app)
    {

    }
}
 