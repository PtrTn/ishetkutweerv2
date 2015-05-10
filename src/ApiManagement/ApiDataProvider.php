<?php

namespace ApiManagement;


use WeatherManagement\WeatherManager;

class ApiDataProvider {

    private $weatherManager;

    public function __construct(WeatherManager $weatherManager) {
        $this->weatherManager = $weatherManager;
    }

    public function getWeatherData() {
        return array(
            'today' => [
                'general' => [
                    'message' => 'Het is geen kutweer',
                    'indicator' => 'good'
                ],
                'specific' =>
                [
                    'rain' => [
                        'value' => '11',
                        'indicator' => 'meh'
                    ],
                    'temperature' => [
                        'value' => '20',
                        'indicator' => 'good'
                    ],
                    'wind' => [
                        'value' => '80',
                        'indicator' => 'bad'
                    ]
                ],
                'message' => $this->weatherManager->getWeatherMessage(),
            ],
            'week' => [
                '1' => [
                    'day' => 'Wo',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
                '2' => [
                    'day' => 'Do',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
                '3' => [
                    'day' => 'Vr',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
                '4' => [
                    'day' => 'Za',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
                '5' => [
                    'day' => 'Zo',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
                '6' => [
                    'day' => 'Ma',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
                '7' => [
                    'day' => 'Di',
                    'rain' => '10',
                    'temperature' => '20',
                    'wind' => '30'
                ],
            ]
        );
    }

    public function getWeatherDataByLatLon($lat, $lon) {
        return $this->weatherManager->getWeather($lat, $lon);
    }

} 