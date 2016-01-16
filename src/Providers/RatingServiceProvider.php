<?php

namespace Providers;

use Rating\RatingCalculator;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RatingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['ratingCalculator'] = function () use ($app) {
            return new RatingCalculator();
        };
    }

    public function boot(Application $app)
    {

    }
}
 