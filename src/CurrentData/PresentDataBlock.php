<?php

namespace CurrentData;

use Helpers\BeaufortCalculator;
use Interfaces\DataBlock;

class PresentDataBlock implements DataBlock
{
    private $stationCode;
    private $date;
    private $temp;
    private $rain;
    private $windSpeed;
    private $windDirection;
    private $sight;
    private $shortMsg;
    private $longMsg;

    public function __construct($stationCode, $date, $temp, $rain, $windSpeed, $windDirection, $sight, $shortMsg, $longMsg)
    {
        // Calculate all variables
        $this->stationCode = $stationCode;
        $this->date = new \DateTime($date);
        $this->temp = floatval(round($temp, 1));
        $this->windSpeed = intval(round($windSpeed * 3.6));
        $this->windDirection = intval(round($windDirection));
        $this->sight = intval(round($sight));
        if ($rain !== '-') {
            $this->rain = floatval(round($rain, 1));
        }
        else {
            $this->rain = 0.0;
        }
        $this->shortMsg = $shortMsg;
        $this->longMsg = $longMsg;
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
        return BeaufortCalculator::getBeaufort($this->windSpeed);
    }

    public function getSight()
    {
        return $this->sight;
    }

    public function getUpdatedTime()
    {
        return $this->date->format('c');
    }

    public function getShortMsg()
    {
        return $this->shortMsg;
    }

    public function getLongMsg()
    {
        return $this->longMsg;
    }

    public function getDate()
    {
        return $this->date;
    }
}
 