<?php

namespace Controllers;

use ForecastData\ForecastDataSource;
use HistoricData\HistoryDataSource;
use Location\LocationDataBlock;
use PresentData\PresentDataSource;
use RainData\RainDataSource;
use Rating\RatingCalculator;
use Station\Station;
use Station\StationFactory;

class DataController
{
    private $stationFactory;
    private $historyDataSource;
    private $presentDataSource;
    private $forecastDataSource;
    private $rainDataSource;
    private $ratingCalculator;
    private $backgroundController;

    public function __construct(
        StationFactory $stationFactory,
        HistoryDataSource $historyDataSource,
        PresentDataSource $presentDataSource,
        ForecastDataSource $forecastDataSource,
        RainDataSource $rainDataSource,
        RatingCalculator $ratingCalculator,
        BackgroundController $backgroundController
    ) {
        $this->stationFactory = $stationFactory;
        $this->historyDataSource = $historyDataSource;
        $this->presentDataSource = $presentDataSource;
        $this->forecastDataSource = $forecastDataSource;
        $this->rainDataSource = $rainDataSource;
        $this->ratingCalculator = $ratingCalculator;
        $this->backgroundController = $backgroundController;
    }

    public function getDataArray(Station $station, LocationDataBlock $location)
    {
        // Get data based on station or location
        $historyData = $this->historyDataSource->getData($station);
        $presentData = $this->presentDataSource->getData($station);
        $forecastData = $this->forecastDataSource->getData($location);

        // Rate current and future weather based on historical data and other rules
        $currentRating = $this->ratingCalculator->getRating($presentData, $historyData);
        $forecastRatings = $this->ratingCalculator->getRatingCollection($forecastData, $historyData);

        // Retrieve weather dependant background
        $backgroundImage = $this->backgroundController->getBackground($presentData);

        // Retrieve weather data for coming 2 hours
        $rainData = $this->rainDataSource->getData($location);

        // Retrieve list of all stations
        $stations = $this->stationFactory->getStations();

        return [
            'station' => $station,
            'stations' => $stations,
            'presentRating' => $currentRating,
            'forecastRatings' => $forecastRatings,
            'historicData' => $historyData,
            'presentData' => $presentData,
            'forecastData' => $forecastData,
            'rainData' => $rainData,
            'backgroundImage' => $backgroundImage
        ];
    }

}
 