<?php

namespace Helpers;

use ForecastData\ForecastWeatherData;

class BackgroundController
{

    public function getBackground(ForecastWeatherData $weatherData)
    {
        $icon = $weatherData->getIcon();
        switch ($icon) {
            case 'clear-day':
                if ($weatherData->getTemp() > 20) {
                    return 'clear-day-2.jpg';
                }
                return 'clear-day-1.jpg';
            case 'rain':
                if ($weatherData->getRain() > 2) {
                    return 'rain-2.jpg';
                }
                return 'rain-1.jpg';
            case 'wind':
                if ($weatherData->getBeaufort() > 7) {
                    return 'wind-2.jpg';
                }
                return 'wind-1.jpg';
            case 'snow':
                return 'snow.jpg';
            case 'sleet':
                return 'sleet.jpg';
            case 'fog':
                return 'fog.jpg';
            case 'cloudy':
                return 'cloudy.jpg';
            case 'partly-cloudy-day':
                return 'partly-cloudy-day.jpg';
            default:
                return $this->getBackupBackground($weatherData);
        }
    }

    private function getBackupBackground(ForecastWeatherData $weatherData)
    {
        return 'default.jpg';
    }

}
 