<?php

namespace ForecastData;

use Helpers\BeaufortCalculator;
use Interfaces\DataBlock;

class ForecastDataBlock implements DataBlock
{
    private $date;
    private $tempMin;
    private $tempMax;
    private $rainProb;
    private $windSpeed;
    private $windDirection;

    public function __construct(
        $date,
        $tempMin,
        $tempMax,
        $rainProb,
        $windSpeed,
        $windDirection
    ) {
        $this->date = $date;
        $this->tempMin = round($tempMin);
        $this->tempMax = round($tempMax);
        $this->rainProb = intval(round($rainProb * 100));
        $this->windSpeed = intval(round($windSpeed));
        $this->windDirection = intval(round($windDirection));
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTemp()
    {
        // TODO fix this!
        return round(($this->tempMin + $this->tempMax) /2);
    }

    public function getTempMax()
    {
        return $this->tempMax;
    }

    public function getTempMin()
    {
        return $this->tempMin;
    }

    public function getRain()
    {
        // TODO fix this!
        return $this->rainProb;
    }

    public function getBeaufort()
    {
        return BeaufortCalculator::getBeaufort($this->windSpeed);
    }

    public function getFormattedDate()
    {
        $month = $this->getMonth($this->date->format('n'));
        $day = $this->date->format('j');
        return $day . ' ' . $month;
    }

    // TODO move this to helper
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

    // TODO move this to helper
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
}
 