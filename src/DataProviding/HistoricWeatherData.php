<?php

namespace DataProviding;

class HistoricWeatherData extends WeatherData
{
    /**
     * Average temperature
     */
    private $tempAvg;
    /**
     * Lowest temperature
     */
    private $tempMin;
    /**
     * Highest temperature
     */
    private $tempMax;
    /**
     * Duur van regenval in uren
     */
    private $rainDuration;
    /**
     * Total sum of rain in millimeters
     */
    private $rainSum;
    /**
     * Maximum amount of rain in 1 hour in millimeters
     */
    private $rainMax;

    public function __construct($stationId, $date, $windDirection, $windSpeed, $tempAvg, $tempMin, $tempMax, $rainDuration, $rainSum, $rainMax)
    {
        parent::__construct($stationId, $date, $windDirection, $windSpeed);
        $this->tempAvg = $tempAvg;
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->rainDuration = $rainDuration;
        $this->rainSum = $rainSum;
        $this->rainMax = $rainMax;
    }
}
 