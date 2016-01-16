<?php

namespace Rating;

use DataProviding\HistoricDataCollection;
use DataProviding\PresentWeatherData;

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
        if ($currentRain <= 0) {
            return 2;
        }
        // TODO maybe add some range to avg (+- 10%)
        if ($currentRain <= $avgRain) {
            return 1;
        }
        return 0;
    }

    private function calcTempRating(PresentWeatherData $presentData, HistoricDataCollection $historicData)
    {
        $avgTemp = $historicData->getTempAvg();
        $currentTemp = $presentData->getTemp();
        // TODO maybe add something when its too hot?
        if ($currentTemp < 0) {
            return 0;
        }
        if ($currentTemp > $avgTemp) {
            return 2;
        }
        return 1;
    }

    private function calcWindRating(PresentWeatherData $presentData, HistoricDataCollection $historicData)
    {
        $avgWind = $historicData->getWindSpeedAvg();
        $currentWind = $presentData->getWindSpeed();
        if ($currentWind > 100) {
            return 0;
        }
        // TODO maybe add some range to avg (+- 10%)
        if ($currentWind <= $avgWind) {
            return 2;
        }
        return 1;
    }

}
 