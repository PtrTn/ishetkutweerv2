<?php

namespace ForecastData;

class ForecastDay
{
    private $date;
    private $maxTemp;
    private $minTemp;
    private $rain;
    private $windSpeed;
    private $beaufort;

    public function __construct($date, $maxTemp, $minTemp, $rain, $windSpeed, $beaufort)
    {
        $this->date = $date;
        $this->maxTemp = $maxTemp;
        $this->minTemp = $minTemp;
        $this->rain = $rain;
        $this->windSpeed = $windSpeed;
        $this->beaufort = $beaufort;
    }

    public function getDayName()
    {
        $dayofWeek = $this->date->format('N');
        switch($dayofWeek) {
            case 1:
                return 'Maandag';
            case 2:
                return 'Dinsdag';
            case 3:
                return 'Woensdag';
            case 4:
                return 'Donderdag';
            case 5:
                return 'Vrijdag';
            case 6:
                return 'Zaterdag';
            case 7:
                return 'Zondag';
            default:
                return false;
        }
    }

    public function getMaxTemp()
    {
        return $this->maxTemp;
    }

    public function getMinTemp()
    {
        return $this->minTemp;
    }

    public function getRain()
    {
        return $this->rain;
    }

    public function getBeaufort()
    {
        return $this->beaufort;
    }
}
 