<?php

namespace Rating;

use ForecastData\ForecastDataBlock;
use ForecastData\ForecastDataCollection;
use HistoricData\HistoryDataCollection;
use Interfaces\DataBlock;
use PresentData\PresentDataBlock;

class RatingCalculator
{
    public function getRatingCollection(ForecastDataCollection $forecastData, HistoryDataCollection $historyData)
    {
        $ratings = new RatingCollection();
        foreach ($forecastData->getDataBlocks() as $forecastDayData) {
            $ratings->add($forecastDayData->getDate(), $this->getForecastRating($forecastDayData, $historyData));
        }
        return $ratings;
    }

    public function getPresentRating(PresentDataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $rainRating = $this->calcRainRating($weatherData, $historyData);
        $tempRating = $this->calcTempRating($weatherData, $historyData);
        $windRating = $this->calcWindRating($weatherData, $historyData);
        return new Rating($rainRating, $tempRating, $windRating);
    }

    private function getForecastRating(ForecastDataBlock $forecastData, HistoryDataCollection $historyData)
    {
        $rainRating = $this->calcRainMaxRating($forecastData, $historyData);
        $tempRating = $this->calcTempMinMaxRating($forecastData, $historyData);
        $windRating = $this->calcWindRating($forecastData, $historyData);
        return new Rating($rainRating, $tempRating, $windRating);
    }

    private function calcRainMaxRating(ForecastDataBlock $forecastData, HistoryDataCollection $historyData)
    {
        $forecastRainMax = $forecastData->getRainMax();
        $rainMaxAvg = $historyData->getRainMaxAvg();
        return $this->calcRainValues($forecastRainMax, $rainMaxAvg);
    }

    private function calcTempMinMaxRating(ForecastDataBlock $forecastData, HistoryDataCollection $historyData)
    {
        $forecastTempMin = $forecastData->getTempMin();
        $forecastTempMax = $forecastData->getTempMax();
        $tempMinAvg = $historyData->getTempMinAvg();
        $tempMaxAvg = $historyData->getTempMaxAvg();
        $minRating = $this->calcTempValues($forecastTempMin, $tempMinAvg);
        $maxRating = $this->calcTempValues($forecastTempMax, $tempMaxAvg);
        $avgRating = intval(round(($minRating + $maxRating) / 2));
        return $avgRating;
    }

    private function calcRainRating(PresentDataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $currentRain = $weatherData->getRain();
        $avgRain = $historyData->getRainAvg();
        return $this->calcRainValues($currentRain, $avgRain);
    }

    private function calcTempRating(PresentDataBlock $weatherData, HistoryDataCollection $historyData)
    {
        $avgTemp = $historyData->getTempAvg();
        $currentTemp = $weatherData->getTemp();
        return $this->calcTempValues($currentTemp, $avgTemp);
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

    private function calcRainValues($actual, $expected)
    {
        // No rain is good
        if ($actual <= 0) {
            return 2;
        }

        // Equal or less rain than normal (with 10% margin) is reasonable
        $margin = 1.1;
        if ($actual <= $expected * $margin) {
            return 1;
        }

        // Anything else is bad
        return 0;
    }

    private function calcTempValues($actual, $expected)
    {
        // Below zero or above 35 deg is bad
        if ($actual < 0 || $actual > 35) {
            return 0;
        }

        // Above 30 is reasonable
        if ($actual > 30) {
            return 1;
        }

        // Anything better or equal to average (with 2 deg margin) is good
        $margin = 2;
        if ($actual >= ($expected - $margin)) {
            return 2;
        }

        // Anything else is reasonable
        return 1;
    }
}
