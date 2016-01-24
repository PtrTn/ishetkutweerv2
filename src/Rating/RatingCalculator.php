<?php

namespace Rating;


use AbstractClasses\WeatherData;
use ForecastData\ForecastData;
use Helpers\RatingCollection;
use HistoricData\HistoricDataCollection;
use PresentData\PresentWeatherData;

class RatingCalculator
{
    public function getRatingCollection(ForecastData $forecastData, HistoricDataCollection $historicData)
    {
        $ratings = new RatingCollection();
        foreach ($forecastData->getDays() as $forecastDayData) {
            $ratings->add($forecastDayData->getDate(), $this->getRating($forecastDayData, $historicData));
        }
        return $ratings;
    }

    public function getRating(WeatherData $weatherData, HistoricDataCollection $historicData)
    {
        $rainRating = $this->calcRainRating($weatherData, $historicData);
        $tempRating = $this->calcTempRating($weatherData, $historicData);
        $windRating = $this->calcWindRating($weatherData, $historicData);
        return new Rating($rainRating, $tempRating, $windRating);
    }

    private function calcRainRating(WeatherData $weatherData, HistoricDataCollection $historicData)
    {
        $avgRain = $historicData->getRainAvg();
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
        return 0;
    }

    private function calcTempRating(WeatherData $weatherData, HistoricDataCollection $historicData)
    {
        $avgTemp = $historicData->getTempAvg();
        $currentTemp = $weatherData->getTemp();

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

    private function calcWindRating(WeatherData $weatherData, HistoricDataCollection $historicData)
    {
        $avgWind = $historicData->getBeaufortAvg();
        $currentWind = $weatherData->getBeaufort();

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
 