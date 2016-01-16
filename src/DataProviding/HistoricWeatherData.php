<?php

namespace DataProviding;

class HistoricWeatherData extends WeatherData
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
     * Duration of rainfall in hours
     */
    private $rainDuration;
    /**
     * Total sum of rain in millimeters
     */
    private $rainSum;
    /**
     * Maximum amount of rain in 1 hour in millimeters
     */
    private $rainMax;

    public function __construct(
        $stationId,
        $date,
        $windDirection,
        $windSpeed,
        $tempAvg,
        $tempMin,
        $tempMax,
        $rainDuration,
        $rainSum,
        $rainMax
    ) {
        parent::__construct($stationId, $date, $windDirection, $windSpeed);
        $this->tempAvg = $tempAvg;
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->rainDuration = $rainDuration;
        $this->rainSum = $rainSum;
        $this->rainMax = $rainMax;
    }

    public function isValid()
    {
        if (
            !isset($this->stationId) ||
            !isset($this->date) ||
            !isset($this->tempAvg) ||
            !isset($this->tempMin) ||
            !isset($this->tempMax) ||
            !isset($this->rainDuration) ||
            !isset($this->rainSum) ||
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

    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    public function getRainSum()
    {
        return $this->rainSum;
    }

    public function getRainDuration()
    {
        return $this->rainDuration;
    }
}
 