<?php

namespace ForecastData;

use AbstractClasses\WeatherData;

class ForecastWeatherData extends WeatherData
{
    /**
     * Average temperature
     */
    private $tempAvg;
    /**
     * Lowest temperature
     */
    private $tempMin;
    /**
     * Highest temperature
     */
    private $tempMax;
    /**
     * Total sum of rain in millimeters
     */
    private $rain;

    public function __construct($date, $windDirection, $windSpeed, $beaufort, $tempAvg, $tempMin, $tempMax, $rain)
    {
        parent::__construct($date, $windDirection, $windSpeed, $beaufort);
        $this->tempAvg = $tempAvg;
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->rain = $rain;
    }

    public function getDayName()
    {
        $dayofWeek = $this->date->format('N');
        switch ($dayofWeek) {
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

    public function getFormattedDate()
    {
        $month = $this->getMonth($this->date->format('n'));
        $day = $this->date->format('j');
        return $day . ' ' . $month;
    }

    public function getTemp()
    {
        return $this->tempAvg;
    }

    public function getMaxTemp()
    {
        return $this->tempMax;
    }

    public function getMinTemp()
    {
        return $this->tempMin;
    }

    public function getRain()
    {
        return $this->rain;
    }

    private function getMonth($month)
    {
        switch ($month) {
            case 1:
                return 'Januari';
            case 2:
                return 'Februari';
            case 3:
                return 'Maart';
            case 4:
                return 'April';
            case 5:
                return 'Mei';
            case 6:
                return 'Juni';
            case 7:
                return 'Juli';
            case 8:
                return 'Augustus';
            case 9:
                return 'Septebmer';
            case 10:
                return 'Oktober';
            case 11:
                return 'November';
            case 12:
                return 'December';
            default:
                return false;
        }
    }
}
 