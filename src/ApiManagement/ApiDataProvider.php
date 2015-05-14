<?php

namespace ApiManagement;


use WeatherManagement\WeatherManager;

/**
 * Class ApiDataProvider
 * @package ApiManagement
 */
class ApiDataProvider {

    /**
     * @var WeatherManager
     */
    private $weatherManager;

    /**
     * @param WeatherManager $weatherManager
     */
    public function __construct(WeatherManager $weatherManager) {
        $this->weatherManager = $weatherManager;
    }

    /**
     * @param $lat
     * @param $lon
     * @return array
     */
    public function getWeatherDataByLatLon($lat = false, $lon = false) {
        $forecast = $this->weatherManager->getForecast($lat, $lon);
        return array(
            'location' => $forecast->getLocation(),
            'today' => [
                'general' => $forecast->getTodayStatus(),
                'specific' => $forecast->getTodayData(),
                'message' => $forecast->getMessage(),
            ],
            'week' => $forecast->getForecastData()
        );
    }
} 