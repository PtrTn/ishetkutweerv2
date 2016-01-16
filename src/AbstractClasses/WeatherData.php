<?php

namespace AbstractClasses;

abstract class WeatherData
{

    /**
     * Triple digit ID of station
     */
    protected $stationId;
    /**
     * Date in dd/mm/yyyy format
     */
    protected $date;
    /**
     * Windspeed in kilometers per hour
     */
    protected $windSpeed;
    /**
     * Wind direction in degrees (0-360)
     */
    protected $windDirection;

    public function __construct($stationId, $date, $windDirection, $windSpeed)
    {
        $this->stationId = $stationId;
        $this->date = $date;
        $this->windSpeed = $windSpeed;
        $this->windDirection = $windDirection;
    }

    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

}
 