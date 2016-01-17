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
     * Wind direction in degrees (0-360)
     */
    protected $windDirection;
    /**
     * Windspeed in kilometers per hour
     */
    protected $windSpeed;
    /**
     * Windspeed on the Beaufort scale
     */
    protected $beaufort;

    public function __construct($stationId, $date, $windDirection, $windSpeed, $beaufort)
    {
        $this->stationId = $stationId;
        $this->date = $date;
        $this->windSpeed = $windSpeed;
        $this->windDirection = $windDirection;
        $this->beaufort = $beaufort;
    }

    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    public function getBeaufort()
    {
        return $this->beaufort;
    }

}
 