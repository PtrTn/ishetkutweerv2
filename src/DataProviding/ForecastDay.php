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

    public function getDayName()
    {
        $dayofWeek = $this->date->format('N');
        switch($dayofWeek) {
            case 1:
                return 'Ma';
            case 2:
                return 'Di';
            case 3:
                return 'Wo';
            case 4:
                return 'Do';
            case 5:
                return 'Vr';
            case 6:
                return 'Za';
            case 7:
                return 'Zo';
            default:
                return false;
        }
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getRain()
    {
        return $this->rain;
    }

    public function getWindSpeed()
    {
        return $this->windSpeed;
    }
}
 