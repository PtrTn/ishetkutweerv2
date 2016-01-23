<?php

namespace Helpers;

use Location\Station;
use Silex\Application;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoutingController
{
    public function renderByIp(Application $app)
    {
        // Get Ip using connection details
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip === '127.0.0.1') {
            $ip = '213.34.236.130';
        }

        // Get location based on IP
        $location = $app['locationDataProvider']->getLocation($ip);

        // Get station based on location
        $station = $app['stationFinder']->findStationByLocation($location);
        return $this->renderByStation($station, $app);
    }

    public function renderBySlug($slug, Application $app)
    {
        // Get station based on url slug
        $station = $app['stationFinder']->findStationBySlug($slug);
        if ($station !== false) {

            // Save location to cookie
            $cookie = new Cookie('location', $slug);
            return $this->renderByStation($station, $app, $cookie);
        }

        // Fall back to Ip based data
        return $this->getDataByIp($app);
    }

    public function renderByCookie(Application $app, Request $request)
    {
        // Check for location in cookies
        $location = $request->cookies->get('location');
        if(!is_null($location)) {
            return $this->renderBySlug($location, $app);
        }
        return false;
    }

    private function renderByStation(Station $station, Application $app, Cookie $cookie = null)
    {
        $stations = $app['stationFactory']->getStations();

        // Get data based on station
        $presentData = $app['presentDataProvider']->getDataByStation($station);
        $historicData = $app['historicDataProvider']->getDataByStation($station);
        $forecastData = $app['forecastDataProvider']->getDataByStation($station);

        // Rate current weather based on historical data and other rules
        $rating = $app['ratingCalculator']->getRating($presentData, $historicData);

        // Render page using found data
        $template =  $app['twig']->render('home.twig', [
            'station' => $station,
            'stations' => $stations,
            'rating' => $rating,
            'historicData' => $historicData,
            'presentData' => $presentData,
            'forecastData' => $forecastData
        ]);

        // Create response
        $response = new Response($template);
        if (!is_null($cookie)) {
            $response->headers->setCookie($cookie);
        }
        return $response;
    }

}
 