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
                return $app->json($app['api_data_provider']->getWeatherDataByLatLon($lat, $lon));
            }
        );

        $controllers->get(
            '/',
            function () use ($app) {
                return $app['twig']->render('api.twig');
            }
        );

        $controllers->get(
            '/weather',
            function () use ($app) {
                return $app->json($app['api_data_provider']->getWeatherDataByLatLon());
            }
        );


        return $controllers;
    }
}
