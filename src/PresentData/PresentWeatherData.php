<?php

namespace PresentData;

use AbstractClasses\WeatherData;

class PresentWeatherData extends WeatherData
{
    /**
     * Triple digit ID of station
     */
    protected $stationId;
    /**
     * Temperature in celsius
     */
    private $temp;
    /**
     * Rain in millimeters per hour
     */
    private $rain;
    /**
     * Sight in amount of meters
     */
    private $sight;
    /**
     * Short text about todays weather
     */
    private $shortMsg;
    /**
     * Long text about todays weather
     */
    private $longMsg;

    public function __construct(
        $date,
        $windDirection,
        $windSpeed,
        $beaufort,
        $stationId,
        $temp,
        $rain,
        $sight,
        $shortMsg,
        $longMsg
    ) {
        parent::__construct($date, $windDirection, $windSpeed, $beaufort);
        $this->stationId = $stationId;
        $this->temp = $temp;
        $this->rain = $rain;
        $this->sight = $sight;
        $this->shortMsg = $shortMsg;
        $this->longMsg = $longMsg;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getRain()
    {
        return $this->rain;
    }

    public function getSight()
    {
        return $this->sight;
    }

    public function getUpdatedTime()
    {
        return $this->date->format('c');
    }

    public function getShortmsg()
    {
        return $this->shortMsg;
    }

    public function getLongmsg()
    {
        return $this->longMsg;
    }
}
 