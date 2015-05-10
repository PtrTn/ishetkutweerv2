<?php

namespace WeatherManagement;


use ApiManagement\ApiClientFactory;

/**
 * Class WeatherManager
 * @package WeatherManagement
 */
class WeatherManager {

    /**
     * @var ApiClientFactory
     */
    private $apiClientFactory;

    /**
     * @param ApiClientFactory $apiClientFactory
     */
    public function __construct(ApiClientFactory $apiClientFactory) {
        $this->apiClientFactory = $apiClientFactory;
    }

    /**
     * @param mixed $lat
     * @param mixed $lon
     * @return mixed
     */
    public function getWeather($lat = false, $lon = false) {
        $client = $this->apiClientFactory->getApiClient('wunderground');
        return $client->getData(['lat' => $lat, 'lon' => $lon]);
    }

    /**
     * @return mixed
     */
    public function getWeatherMessage() {
        try {
            $data = $this->apiClientFactory->getApiClient('buienradar')->getData();
        }
        catch(\Exception $e) {

        }
        if(!empty($data)) {
            return $data;
        }

        try {
            $data = $this->apiClientFactory->getApiClient('knmi')->getData();
        }
        catch(\Exception $e) {

        }
        if(!empty($data)) {
            return $data;
        }
        return 'Er kan geen weerbericht worden opgehaald';
    }

} 