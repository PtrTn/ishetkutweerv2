<?php

namespace Helpers;

use Location\Station;
use Silex\Application;

class RoutingController
{
    public function getDataByIp(Application $app)
    {
        // Get IP using connection details
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

    public function getDataBySlug($slug, Application $app)
    {
        // Get station based on url slug
        $station = $app['stationFinder']->findStationBySlug($slug);
        if ($station !== false) {
            return $this->renderByStation($station, $app);
        }
        echo 'using IP fallback';
        return $this->getDataByIp($app);
    }

    private function renderByStation(Station $station, Application $app)
    {
        $stations = $app['stationFactory']->getStations();

        // Get data based on station
        $presentData = $app['presentDataProvider']->getDataByStation($station);
        $historicData = $app['historicDataProvider']->getDataByStation($station);
        $forecastData = $app['forecastDataProvider']->getDataByStation($station);

        // Rate current weather based on historical data and other rules
        $rating = $app['ratingCalculator']->getRating($presentData, $historicData);

        // Render page using found data
        return $app['twig']->render('home.twig', [
            'station' => $station,
            'stations' => $stations,
            'rating' => $rating,
            'historicData' => $historicData,
            'presentData' => $presentData,
            'forecastData' => $forecastData
        ]);
    }

}
 