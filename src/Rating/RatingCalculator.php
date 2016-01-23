<?php

namespace Rating;


use HistoricData\HistoricDataCollection;
use PresentData\PresentWeatherData;

class RatingCalculator
{
    public function getRating(PresentWeatherData $presentData, HistoricDataCollection $historicData)
    {
        $rainRating = $this->calcRainRating($presentData, $historicData);
        $tempRating = $this->calcTempRating($presentData, $historicData);
        $windRating = $this->calcWindRating($presentData, $historicData);
        return new Rating($rainRating, $tempRating, $windRating);
    }

    private function calcRainRating(PresentWeatherData $presentData, HistoricDataCollection $historicData)
    {
        $avgRain = $historicData->getRainAvg();
        $currentRain = $presentData->getRain();

        // No rain is good
        if ($currentRain <= 0) {
            return 2;
        }

        // Equal or less rain than normal (with 10% margin) is reasonable
        $margin = 1.1;
        if ($currentRain <= $avgRain * $margin) {
            return 1;
        }
        return 0;
    }

    private function calcTempRating(PresentWeatherData $presentData, HistoricDataCollection $historicData)
    {
        $avgTemp = $historicData->getTempAvg();
        $currentTemp = $presentData->getTemp();

        // Below zero or above 35 deg is bad
        if ($currentTemp < 0 || $currentTemp > 35) {
            return 0;
        }

        // Above 30 is reasonable
        if ($currentTemp > 30) {
            return 2;
        }

        // Anything better or equal to average (with 2 deg margin) is reasonable
        $margin = 2;
        if ($currentTemp >= ($avgTemp - $margin)) {
            return 2;
        }
        return 1;
    }

    private function calcWindRating(PresentWeatherData $presentData, HistoricDataCollection $historicData)
    {
        $avgWind = $historicData->getBeaufortAvg();
        $currentWind = $presentData->getBeaufort();

        // Anything above 8 bft is bad
        if ($currentWind >= 8) {
            return 0;
        }

        $margin = 1;
        // Equal or lower than average (with 1 bft margin) is reasonable
        if ($currentWind <= ($avgWind + $margin)) {
            return 2;
        }
        return 1;
    }

}
 