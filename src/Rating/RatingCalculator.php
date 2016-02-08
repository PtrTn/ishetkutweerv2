<?php

namespace Rating;

use ForecastData\ForecastDataCollection;
use HistoricData\HistoryDataCollection;
use Interfaces\DataBlock;

class RatingCalculator
{
    public function getRatingCollection(ForecastDataCollection $forecastData, HistoryDataCollection $historyData)
    {
        $ratings = new RatingCollection();
        foreach ($forecastData->getDataBlocks() as $forecastDayData) {
            $ratings->add($forecastDayData->getDate(), $this->getRating($forecastDayData, $historyData));
        }
        return $ratings;
    }

    public function getRating(DataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $rainRating = $this->calcRainRating($weatherData, $historyData);
        $tempRating = $this->calcTempRating($weatherData, $historyData);
        $windRating = $this->calcWindRating($weatherData, $historyData);
        return new Rating($rainRating, $tempRating, $windRating);
    }

    private function calcRainRating(DataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $avgRain = $historyData->getRainAvg();
        $currentRain = $weatherData->getRain();

        // No rain is good
        if ($currentRain <= 0) {
            return 2;
        }

        // Equal or less rain than normal (with 10% margin) is reasonable
        $margin = 1.1;
        if ($currentRain <= $avgRain * $margin) {
            return 1;
        }

        // Anything else is bad
        return 0;
    }

    private function calcTempRating(DataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $avgTemp = $historyData->getTempAvg();
        $currentTemp = $weatherData->getTemp();

        // Below zero or above 35 deg is bad
        if ($currentTemp < 0 || $currentTemp > 35) {
            return 0;
        }

        // Above 30 is reasonable
        if ($currentTemp > 30) {
            return 2;
        }

        // Anything better or equal to average (with 2 deg margin) is good
        $margin = 2;
        if ($currentTemp >= ($avgTemp - $margin)) {
            return 2;
        }

        // Anything else is reasonable
        return 1;
    }

    private function calcWindRating(DataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $avgWind = $historyData->getBeaufortAvg();
        $currentWind = $weatherData->getBeaufort();

        // Anything above 8 bft is bad
        if ($currentWind >= 8) {
            return 0;
        }

        // Equal or lower than average (with 1 bft margin) is good
        $margin = 1;
        if ($currentWind <= ($avgWind + $margin)) {
            return 2;
        }

        // Anything else is reasonable
        return 1;
    }

}
 