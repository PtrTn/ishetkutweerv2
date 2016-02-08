<?php

namespace ForecastData;

use Helpers\BeaufortCalculator;
use Helpers\DateFormatter;
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
        $monthOfYear = $this->date->format('n');
        $monthName = DateFormatter::getMonthName($monthOfYear);
        $day = $this->date->format('j');
        return $day . ' ' . $monthName;
    }

    public function getDayName()
    {
        $dayOfWeek = $this->date->format('N');
        return DateFormatter::getDayName($dayOfWeek);
    }
}
 