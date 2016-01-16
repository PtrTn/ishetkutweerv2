<?php

namespace DataProviding;

class ForecastData
{
    private $days;

    public function __construct()
    {
        $this->days = [];
    }

    public function add(ForecastDay $day)
    {
        $this->days[] = $day;
    }

    public function getDays($amount = false)
    {
        if ($amount !== false) {
            return array_slice($this->days, 0, $amount);
        }
        return $this->days;
    }
}
 