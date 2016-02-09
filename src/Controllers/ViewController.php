<?php

namespace Controllers;

use ForecastData\ForecastDataSource;
use HistoricData\HistoryDataSource;
use Location\LocationDataBlock;
use PresentData\PresentDataSource;
use RainData\RainDataSource;
use Rating\RatingCalculator;
use Silex\Application;
use Station\Station;
use Station\StationFactory;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ViewController
{
    private $stationFactory;
    private $historyDataSource;
    private $presentDataSource;
    private $forecastDataSource;
    private $rainDataSource;
    private $ratingCalculator;
    private $backgroundController;
    private $twig;

    public function __construct(
        StationFactory $stationFactory,
        HistoryDataSource $historyDataSource,
        PresentDataSource $presentDataSource,
        ForecastDataSource $forecastDataSource,
        RainDataSource $rainDataSource,
        RatingCalculator $ratingCalculator,
        BackgroundController $backgroundController,
        \Twig_Environment $twig
    ) {
        $this->stationFactory = $stationFactory;
        $this->historyDataSource = $historyDataSource;
        $this->presentDataSource = $presentDataSource;
        $this->forecastDataSource = $forecastDataSource;
        $this->rainDataSource = $rainDataSource;
        $this->ratingCalculator = $ratingCalculator;
        $this->backgroundController = $backgroundController;
        $this->twig = $twig;
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
        $stations = $this->stationFactory->getStations();

        // Get data based on station
        $historyData = $this->historyDataSource->getData($station);
        $presentData = $this->presentDataSource->getData($station);

        // Prefer given location over station location
        if (is_null($location)) {
            $location = $station->getLocation();
        }
        $forecastData = $this->forecastDataSource->getData($location);

        // Rate current and future weather based on historical data and other rules
        $currentRating = $this->ratingCalculator->getRating($presentData, $historyData);
        $forecastRatings = $this->ratingCalculator->getRatingCollection($forecastData, $historyData);

        // Retrieve weather dependant background
        $backgroundImage = $this->backgroundController->getBackground($presentData);

        // Retrieve weather data for coming 2 hours
        $rainData = $this->rainDataSource->getData($location);

        // Render page using found data
        return $this->twig->render('home.twig', [
            'station' => $station,
            'stations' => $stations,
            'presentRating' => $currentRating,
            'forecastRatings' => $forecastRatings,
            'historicData' => $historyData,
            'presentData' => $presentData,
            'forecastData' => $forecastData,
            'rainData' => $rainData,
            'backgroundImage' => $backgroundImage
        ]);
    }

}
 