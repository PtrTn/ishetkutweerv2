<?php

namespace ForecastData;

class ForecastDataCollection
{
    private $days;

    public function __construct()
    {
        $this->days = [];
    }

    public function add(ForecastWeatherData $day)
    {
        $this->days[] = $day;
    }

    public function getDays($start = false, $amount = false)
    {
        if ($amount !== false && $start !== false) {
            return array_slice($this->days, $start, $amount);
        }
        return $this->days;
    }
}
 