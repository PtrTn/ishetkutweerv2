<?php

namespace DataProviding;

class ForecastDay
{
    private $date;
    private $temp;
    private $rain;
    private $windSpeed;

    public function __construct($date, $temp, $rain, $windSpeed)
    {
        $this->date = $date;
        $this->temp = $temp;
        $this->rain = $rain;
        $this->windSpeed = $windSpeed;
    }
}
 