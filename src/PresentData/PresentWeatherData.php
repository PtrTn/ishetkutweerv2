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
    /**
     * Windspeed on the Beaufort scale
     */
    protected $beaufort;

    public function __construct($stationId, $date, $windSpeed, $beaufort, $windDirection, $temp, $rain)
    {
        parent::__construct($stationId, $date, $windDirection, $windSpeed);
        $this->temp = $temp;
        $this->rain = $rain;
        $this->beaufort = $beaufort;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getRain()
    {
        return $this->rain;
    }

    public function getBeaufort()
    {
        return $this->beaufort;
    }
}
 