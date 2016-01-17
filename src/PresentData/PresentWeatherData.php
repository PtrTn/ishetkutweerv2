<?php

namespace PresentData;

use AbstractClasses\WeatherData;

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

    public function __construct($stationId, $date, $windDirection, $windSpeed, $beaufort, $temp, $rain)
    {
        parent::__construct($stationId, $date, $windDirection, $windSpeed, $beaufort);
        $this->temp = $temp;
        $this->rain = $rain;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getRain()
    {
        return $this->rain;
    }
}
 