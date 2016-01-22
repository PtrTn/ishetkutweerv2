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
     * Short text about todays weather
     */
    private $shortMsg;
    /**
     * Long text about todays weather
     */
    private $longMsg;

    public function __construct($stationId, $date, $windDirection, $windSpeed, $beaufort, $temp, $rain, $shortMsg, $longMsg)
    {
        parent::__construct($stationId, $date, $windDirection, $windSpeed, $beaufort);
        $this->temp = $temp;
        $this->rain = $rain;
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

    public function getUpdatedTime()
    {
        return date('H:i', strtotime($this->date));
    }

    public function getShortmsg() {
        return $this->shortMsg;
    }

    public function getLongmsg() {
        return $this->longMsg;
    }
}
 