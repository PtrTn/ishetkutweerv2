<?php

namespace ForecastData;

use Helpers\BeaufortCalculator;
use Interfaces\DataProviderInterface;
use Location\Location;
use VertigoLabs\Overcast\Overcast;

class ForecastDataProvider implements DataProviderInterface
{
    private $overcast;
    private $beaufortCalculator;

    public function __construct(Overcast $overcast, BeaufortCalculator $beaufortCalculator)
    {
        $this->overcast = $overcast;
        $this->beaufortCalculator = $beaufortCalculator;
    }

    public function getDataByLocation(Location $location)
    {
        $data = $this->overcast->getForecast(
            $location->getLat(),
            $location->getLon(),
            null,
            ['units' => 'ca']
        );
        return $this->toForecastData($data);
    }

    private function toForecastData($data)
    {
        $forecast = new ForecastDataCollection();
        foreach($data->getDaily()->getData() as $dayData) {
            $icon = $dayData->getIcon();
            $maxTemp = round($dayData->getTemperature()->getMax());
            $minTemp = round($dayData->getTemperature()->getMin());
            $avgTemp = round(($dayData->getTemperature()->getMax() + $dayData->getTemperature()->getMin()) / 2);
            $rain = intval(round($dayData->getPrecipitation()->getProbability() * 100));
            $windSpeed = intval(round($dayData->getWindSpeed()));
            $windDirection = intval(round($dayData->getWindBearing()));
            $beaufort = $this->beaufortCalculator->getBeaufort($windSpeed);
            $forecast->add(new ForecastWeatherData(
                $dayData->getTime(),
                $windDirection,
                $windSpeed,
                $beaufort,
                $avgTemp,
                $minTemp,
                $maxTemp,
                $rain,
                $icon
            ));
        }
        return $forecast;
    }
}
 