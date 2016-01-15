<?php

namespace DataProviding;

class HistoricDataCollection
{
    private $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function add(HistoricWeatherData $weatherData)
    {
        $this->collection[] = $weatherData;
    }

}
 