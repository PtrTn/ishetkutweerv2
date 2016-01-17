<?php

namespace ForecastData;

class ForecastDay
{
    private $date;
    private $temp;
    private $rain;
    private $windSpeed;
    private $beaufort;

    public function __construct($date, $temp, $rain, $windSpeed, $beaufort)
    {
        $this->date = $date;
        $this->temp = $temp;
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

    public function getTemp()
    {
        return $this->temp;
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
 