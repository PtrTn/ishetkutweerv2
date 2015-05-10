<?php

namespace Routing;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * Class ApiControllerProvider
 *
 * @package ScenarioApi
 */
class ApiControllerProvider implements ControllerProviderInterface
{

    /**
     * @param Application $app
     *
     * @return mixed
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get(
            '/weather/{lat}/{lon}',
            function ($lat, $lon) use ($app) {
                return $app->json($app['weather_manager']->getWeather($lat, $lon));
            }
        );

        $controllers->get(
            '/weather',
            function () use ($app) {
                return $app->json($app['weather_manager']->getWeather());
            }
        );

        $controllers->get(
            'weather/message',
            function () use ($app) {
                return $app->json($app['weather_manager']->getWeatherMessage());
            }
        );


        return $controllers;
    }
}
