<?php

namespace CurrentData;

use Interfaces\DataFactory;
use Interfaces\DataSource;
use Interfaces\HttpClient;
use Location\Station;

class CurrentDataSource implements DataSource
{
    private $httpClient;
    private $dataFactory;
    private $apiUrl;

    public function __construct(HttpClient $httpClient, DataFactory $dataFactory, $apiUrl)
    {
        $this->httpClient = $httpClient;
        $this->dataFactory = $dataFactory;
        $this->apiUrl = $apiUrl;
    }

    public function getData(Station $station = null)
    {
        if (is_null($station)) {
            throw new \LogicException('No Station provided for LocationDataSource');
        }
        $data = $this->httpClient->getData($this->apiUrl);
        if(!isset($data) || empty($data)) {
            throw new \RuntimeException('No current data found');
        }
        return $this->dataFactory->createDataBlock($data, $station);
    }
}
 