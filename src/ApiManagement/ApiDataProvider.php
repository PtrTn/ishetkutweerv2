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
    public function getWeatherDataByLatLon($lat, $lon) {
        $forecast = $this->weatherManager->getForecast($lat, $lon);
        return array(
            'today' => [
                'general' => [
                    'message' => 'Het is geen kutweer',
                    'indicator' => 'good'
                ],
                'specific' => $forecast->getToday()->toEnrichedArray(),
                'message' => $this->weatherManager->getWeatherMessage(),
            ],
            'week' => $forecast->toArray()
        );
    }
} 