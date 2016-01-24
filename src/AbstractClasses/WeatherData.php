<?php

namespace AbstractClasses;

abstract class WeatherData
{
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

    public function __construct($date, $windDirection, $windSpeed, $beaufort)
    {
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

    public function getDate()
    {
        return $this->date;
    }

}
 