<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 3-5-2015
 * Time: 19:09
 */

namespace WeatherManagement;


use ApiManagement\ApiClient;
use LocationManagement\LocationManager;

class WeatherManager {

    private $apiClient;
    private $locationManager;

    public function __construct(ApiClient $apiClient, LocationManager $locationManager) {
        $this->apiClient = $apiClient;
        $this->locationManager = $locationManager;
    }

    public function getWeather() {
        return $this->apiClient->getData();
    }

} 