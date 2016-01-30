<?php

namespace Helpers;

use Location\Location;
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
            return $this->renderByStation($station, $app);
        }

        // Fall back to Ip based data
        return $this->renderByIp($app);
    }

    public function renderByCookie(Application $app, Request $request)
    {
        // Check for location in cookies
        $location = $request->cookies->get('location');
        if(!is_null($location)) {
            return $this->renderBySlug($location, $app);
        }

        // Check for id in cookies (backwards compatibility with ishetkutweer v1)
        $stationId = $request->cookies->get('station');
        if(!is_null($stationId)) {
            return $this->renderByStationId($stationId, $app);
        }

        return false;
    }

    public function renderByLatLon($lat, $lon, Application $app)
    {
        // Create location model
        $location = new Location($lat, $lon);

        // Get station based on location
        $station = $app['stationFinder']->findStationByLocation($location);
        return $this->renderByStation($station, $app);
    }

    private function renderByStationId($id, $app)
    {
        // Get station based on url slug
        $station = $app['stationFinder']->findStationById($id);
        if ($station !== false) {
            return $this->renderByStation($station, $app);
        }

        // Fall back to Ip based data
        return $this->renderByIp($app);
    }

    private function renderByStation(Station $station, Application $app)
    {
        $stations = $app['stationFactory']->getStations();

        // Get data based on station
        $historicData = $app['historicDataProvider']->getDataByStation($station);
        $presentData = $app['presentDataProvider']->getDataByStation($station);
        $forecastData = $app['forecastDataProvider']->getDataByLocation($station->getLocation());

        // Rate current weather based on historical data and other rules
        $presentRating = $app['ratingCalculator']->getRating($presentData, $historicData);
        $forecastRatings = $app['ratingCalculator']->getRatingCollection($forecastData, $historicData);

        // Retrieve weather dependant background
        $backgroundImage = $app['backgroundController']->getBackground($presentData);

        // Render page using found data
        $template =  $app['twig']->render('home.twig', [
            'station' => $station,
            'stations' => $stations,
            'presentRating' => $presentRating,
            'forecastRatings' => $forecastRatings,
            'historicData' => $historicData,
            'presentData' => $presentData,
            'forecastData' => $forecastData,
            'backgroundImage' => $backgroundImage
        ]);

        // Create response
        $response = new Response($template);

        // Save location to cookie
        $cookie = new Cookie('location', $station->getSlug());
        $response->headers->setCookie($cookie);
        return $response;
    }

}
 