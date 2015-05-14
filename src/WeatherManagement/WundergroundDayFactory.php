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
        $location = $this->extractLocation($data);
        $forecast = new Forecast($location);
        foreach ($daysData as $dayData) {
            if (isset($dayData['high']['celsius'])
                && isset($dayData['low']['celsius'])
                && isset($dayData['avewind']['kph'])
                && isset($dayData['qpf_allday']['mm'])
                && isset($dayData['date']['epoch'])
            ) {
                $forecast->addDay(new Day(
                    $dayData['date']['epoch'],
                    new Measurement('rain', $dayData['qpf_allday']['mm']),
                    new Measurement('temp', false, $dayData['low']['celsius'], $dayData['high']['celsius']),
                    new Measurement('wind', $dayData['avewind']['kph'])
                ));
            }
        }
        return $forecast;
    }

    /**
     * @param $data
     * @return array
     */
    private function extractForecastDays($data)
    {
        if (empty($data['forecast']['simpleforecast']['forecastday'])) {
            throw new \RuntimeException('Unable to extract forecast data');
        }
        return $data['forecast']['simpleforecast']['forecastday'];
    }

    /**
     * @param $data
     * @return string
     */
    private function extractLocation($data) {
        if (!empty($data['location']['city'])) {
            return $data['location']['city'];
        }
        if (!empty($data['location']['country_name'])) {
            return $data['location']['country_name'];
        }

        throw new \RuntimeException('Unable to extract location');
    }

} 