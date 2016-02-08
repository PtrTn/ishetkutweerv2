<?php

namespace Controllers;

use Location\LocationDataBlock;
use Location\Station;
use Silex\Application;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoutingController
{
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

    public function renderByLatLon($lat, $lon, Application $app)
    {
        // Create location model
        $location = new LocationDataBlock($lat, $lon);
        return $this->renderByLocation($location, $app);
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

    public function renderByIp(Application $app)
    {
        // Get Ip using connection details
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip === '127.0.0.1') {
            $ip = '213.34.236.130';
        }

        // Get location based on IP
        $location = $app['locationDataSource']->getData($ip);
        return $this->renderByLocation($location, $app);
    }

    private function renderByLocation(LocationDataBlock $location, Application $app)
    {
        // Get station based on location
        $station = $app['stationFinder']->findStationByLocation($location);
        return $this->renderByStation($station, $app, $location);
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

    private function renderByStation(Station $station, Application $app, LocationDataBlock $location = null)
    {
        $stations = $app['stationFactory']->getStations();

        // Get data based on station
        $historyData = $app['historyDataSource']->getData($station);
        $presentData = $app['presentDataSource']->getData($station);

        // Prefer given location over station location
        if (is_null($location)) {
            $location = $station->getLocation();
        }
        $forecastData = $app['forecastDataSource']->getData($location);

        // Rate current and future weather based on historical data and other rules
        $currentRating = $app['ratingCalculator']->getRating($presentData, $historyData);
        $forecastRatings = $app['ratingCalculator']->getRatingCollection($forecastData, $historyData);

        // Retrieve weather dependant background
        $backgroundImage = $app['backgroundController']->getBackground($presentData);

        // Retrieve weather data for coming 2 hours
        $rainData = $app['rainDataProvider']->getDataByLocation($location);

        // Render page using found data
        $template =  $app['twig']->render('home.twig', [
            'station' => $station,
            'stations' => $stations,
            'presentRating' => $currentRating,
            'forecastRatings' => $forecastRatings,
            'historicData' => $historyData,
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
 