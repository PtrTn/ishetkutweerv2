<?php

namespace DataProviding;

class PresentWeatherData extends WeatherData
{
    /**
     * Temperature in celsius
     */
    private $temp;
    /**
     * Rain in millimeters per hour
     */
    private $rain;

    public function __construct($stationId, $date, $windSpeed, $windDirection, $temp, $rain)
    {
        parent::__construct($stationId, $date, $windDirection, $windSpeed);
        $this->temp = $temp;
        $this->rain = $rain;
    }
}
 