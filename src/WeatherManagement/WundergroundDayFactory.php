<?php

namespace WeatherManagement;

/**
 * Class WundergroundDayFactory
 * @package WeatherManagement
 */
class WundergroundDayFactory
{

    /**
     * @param $data
     * @return mixed
     */
    public function createForecast($data)
    {
        $daysData = $this->extractForecastDays($data);
        $forecast = new Forecast();
        foreach ($daysData as $dayData) {
            if (isset($dayData['high']['celsius'])
                && isset($dayData['low']['celsius'])
                && isset($dayData['avewind']['kph'])
                && isset($dayData['qpf_allday']['mm'])
                && isset($dayData['date']['epoch'])
            ) {
                $forecast->addDay(new Day(
                    $dayData['date']['epoch'],
                    new Measurement('Rain', $dayData['qpf_allday']['mm']),
                    new Measurement('Temp', false, $dayData['low']['celsius'], $dayData['high']['celsius']),
                    new Measurement('Wind', $dayData['avewind']['kph'])
                ));
            }
        }
        return $forecast;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function extractForecastDays($data)
    {
        if (empty($data['forecast']['simpleforecast']['forecastday'])) {
            throw new \RuntimeException('Unable to extract correct data');
        }
        return $data['forecast']['simpleforecast']['forecastday'];
    }

} 