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

}
 