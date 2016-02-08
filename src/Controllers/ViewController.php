<?php

namespace Controllers;

use Location\LocationDataBlock;
use Location\Station;
use Silex\Application;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ViewController
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function loadView(Station $station, LocationDataBlock $location = null)
    {
        // Load template including requried data
        $template = $this->getTemplate($station, $location);

        // Create response
        $response = new Response($template);

        // Save location to cookie
        $cookie = new Cookie('location', $station->getSlug());
        $response->headers->setCookie($cookie);
        return $response;
    }

    private function getTemplate(Station $station, LocationDataBlock $location = null)
    {
        $stations = $this->app['stationFactory']->getStations();

        // Get data based on station
        $historyData = $this->app['historyDataSource']->getData($station);
        $presentData = $this->app['presentDataSource']->getData($station);

        // Prefer given location over station location
        if (is_null($location)) {
            $location = $station->getLocation();
        }
        $forecastData = $this->app['forecastDataSource']->getData($location);

        // Rate current and future weather based on historical data and other rules
        $currentRating = $this->app['ratingCalculator']->getRating($presentData, $historyData);
        $forecastRatings = $this->app['ratingCalculator']->getRatingCollection($forecastData, $historyData);

        // Retrieve weather dependant background
        $backgroundImage = $this->app['backgroundController']->getBackground($presentData);

        // Retrieve weather data for coming 2 hours
        $rainData = $this->app['rainDataSource']->getData($location);

        // Render page using found data
        return $this->app['twig']->render('home.twig', [
            'station' => $station,
            'stations' => $stations,
            'presentRating' => $currentRating,
            'forecastRatings' => $forecastRatings,
            'historicData' => $historyData,
            'presentData' => $presentData,
            'forecastData' => $forecastData,
            'backgroundImage' => $backgroundImage
        ]);
    }

}
 