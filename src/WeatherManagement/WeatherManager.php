<?php

namespace WeatherManagement;


use ApiManagement\ApiClientFactory;

/**
 * Class WeatherManager
 * @package WeatherManagement
 */
class WeatherManager
{

    /**
     * @var ApiClientFactory
     */
    private $apiClientFactory;

    /**
     * @var WundergroundDayFactory
     */
    private $dayFactory;

    /**
     * @var RatingDecorator
     */
    private $ratingDecorator;

    /**
     * @param ApiClientFactory $apiClientFactory
     * @param WundergroundDayFactory $dayFactory
     * @param RatingDecorator $ratingDecorator
     */
    public function __construct(
        ApiClientFactory $apiClientFactory,
        WundergroundDayFactory $dayFactory,
        RatingDecorator $ratingDecorator
    ) {
        $this->apiClientFactory = $apiClientFactory;
        $this->dayFactory = $dayFactory;
        $this->ratingDecorator = $ratingDecorator;
    }

    /**
     * @param mixed $lat
     * @param mixed $lon
     * @return mixed
     */
    public function getForecast($lat = false, $lon = false)
    {
        $client = $this->apiClientFactory->getApiClient('wunderground');
        $data = $client->getData(['lat' => $lat, 'lon' => $lon]);
        $forecast = $this->dayFactory->createForecast($data);
        $forecast->setMessage($this->getWeatherMessage());
        return $this->ratingDecorator->decorate($forecast);
    }

    /**
     * @return mixed
     */
    public function getWeatherMessage()
    {
        try {
            $data = $this->apiClientFactory->getApiClient('buienradar')->getData();
        } catch (\Exception $e) {

        }
        if (!empty($data)) {
            return $data;
        }

        try {
            $data = $this->apiClientFactory->getApiClient('knmi')->getData();
        } catch (\Exception $e) {

        }
        if (!empty($data)) {
            return $data;
        }
        return 'Er kan geen weerbericht worden opgehaald';
    }

} 