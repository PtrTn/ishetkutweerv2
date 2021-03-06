<?php

namespace Controllers;

use Location\LocationDataBlock;
use Location\LocationDataSource;
use Silex\Application;
use Station\Station;
use Station\StationFinder;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoutingController
{
    private $viewController;
    private $stationFinder;
    private $locationDataSource;

    public function __construct(ViewController $viewController, StationFinder $stationFinder, LocationDataSource $locationDataSource)
    {
        $this->viewController = $viewController;
        $this->stationFinder = $stationFinder;
        $this->locationDataSource = $locationDataSource;
    }

    public function renderBySlug($slug)
    {
        // Get station based on url slug
        $station = $this->stationFinder->findStationBySlug($slug);

        if (!is_null($station)) {
            return $this->renderView($station);
        }

        // Fall back to Ip based data
        return $this->renderByIp();
    }

    public function renderByLatLon($lat, $lon)
    {
        // Create location model
        $location = new LocationDataBlock($lat, $lon, 'Gps');
        return $this->renderByLocation($location);
    }

    public function renderByCookie(Request $request)
    {
        // Check for location in cookies
        $location = $request->cookies->get('location');
        if(!is_null($location)) {
            return $this->renderBySlug($location);
        }

        // Check for id in cookies (backwards compatibility with ishetkutweer v1)
        $stationId = $request->cookies->get('station');
        if(!is_null($stationId)) {
            return $this->renderByStationId($stationId);
        }

        // Fall back to Ip based data
        return $this->renderByIp();
    }

    public function renderByIp()
    {
        // Get Ip using connection details
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip === '127.0.0.1') {
            $ip = '62.238.138.125';
        }

        // Get location based on IP
        $location = $this->locationDataSource->getData($ip);
        return $this->renderByLocation($location);
    }

    private function renderByLocation(LocationDataBlock $location)
    {
        // Get station based on location
        $station = $this->stationFinder->findStationByLocation($location);
        return $this->renderView($station, $location);
    }

    private function renderByStationId($id)
    {
        // Get station based on url slug
        $station = $this->stationFinder->findStationById($id);

        if (!is_null($station)) {
            return $this->renderView($station);
        }

        // Fall back to Ip based data
        return $this->renderByIp();
    }
    
    private function renderView(Station $station, LocationDataBlock $location = null)
    {
        // Prefer given location over station location
        if (is_null($location)) {
            $location = $station->getLocation();
        }

        // Retrieve view
        $view = $this->viewController->getView($station, $location);

        // Create response
        $response = new Response($view);

        // Save location to cookie
        $cookie = new Cookie('location', $station->getSlug());
        $response->headers->setCookie($cookie);

        // Return created response
        return $response;
    }
}
 