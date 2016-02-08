<?php

namespace RainData;

use Interfaces\DataFactory;
use Interfaces\DataSource;
use Interfaces\HttpClient;
use Location\LocationDataBlock;

class RainDataSource implements DataSource
{
    private $dataFactory;
    private $httpClient;
    private $baseUrl;

    public function __construct(DataFactory $dataFactory, HttpClient $httpClient, $baseUrl)
    {
        $this->dataFactory = $dataFactory;
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    public function getData(LocationDataBlock $location = null)
    {
        if (is_null($location)) {
            throw new \LogicException('No Location provided for RainDataSource');
        }
        $url = $this->createUrl($location);
        $data = $this->httpClient->getData($url);
        return $this->dataFactory->createDataBlock($data);
    }

    private function createUrl(LocationDataBlock $location)
    {
        $parameters = [
            'lat' => $location->getLat(),
            'lon' => $location->getLon()
        ];
        $query = http_build_query($parameters);
        return $this->baseUrl . '?' . $query;
    }
}
 