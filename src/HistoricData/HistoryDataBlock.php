<?php

namespace HistoricData;

use Helpers\BeaufortCalculator;
use Interfaces\DataBlock;

class HistoryDataBlock implements DataBlock
{
    private $stationCode;
    private $date;
    private $tempAvg;
    private $tempMin;
    private $tempMax;
    private $rainDuration;
    private $rainSum;
    private $rainMax;
    private $windSpeed;
    private $windDirection;

    public function __construct(
        $stationCode,
        $date,
        $tempAvg,
        $tempMin,
        $tempMax,
        $rainDuration,
        $rainSum,
        $rainMax,
        $windSpeed,
        $windDirection
    ) {
        $this->stationCode = $stationCode;
        $this->date = new \DateTime($date);
        $this->tempAvg = floatval(round($tempAvg / 10, 1));
        $this->tempMin = floatval(round($tempMin / 10, 1));
        $this->tempMax = floatval(round($tempMax / 10, 1));
        $this->windSpeed = intval($windSpeed * 3.6 / 10);
        $this->windDirection = intval($windDirection);
        $this->rainSum = floatval(round($rainSum / 10, 1));
        $this->rainDuration = floatval(round($rainDuration / 10, 1));
        if ($rainMax !== -1) {
            $this->rainMax = floatval(round(((int)$rainMax) / 10, 1));
        }
        else {
            $this->rainMax = 0;
        }
    }

    public function isValid()
    {
        if (
            !isset($this->stationCode) ||
            !isset($this->date) ||
            !isset($this->tempAvg) ||
            !isset($this->tempMin) ||
            !isset($this->tempMax) ||
            !isset($this->windSpeed) ||
            !isset($this->windDirection) ||
            !isset($this->rainSum) ||
            !isset($this->rainDuration) ||
            !isset($this->rainMax)
        ) {
            return false;
        }
        return true;
    }

    public function getTempAvg()
    {
        return $this->tempAvg;
    }

    public function getTempMin()
    {
        return $this->tempMin;
    }

    public function getTempMax()
    {
        return $this->tempMax;
    }

    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    public function getRainSum()
    {
        return $this->rainSum;
    }

    public function getRainMax()
    {
        return $this->rainMax;
    }

    public function getRainDuration()
    {
        return $this->rainDuration;
    }

    public function getBeaufort()
    {
        return BeaufortCalculator::getBeaufort($this->windSpeed);
    }
}
 