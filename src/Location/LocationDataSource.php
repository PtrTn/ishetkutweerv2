<?php

namespace Location;

use Interfaces\DataFactory;
use Interfaces\DataSource;
use Interfaces\HttpClient;

class LocationDataSource implements DataSource
{
    private $httpClient;
    private $dataFactory;
    private $baseUrl;

    public function __construct(HttpClient $httpClient, DataFactory $dataFactory, $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->dataFactory = $dataFactory;
        $this->baseUrl = $baseUrl;
    }

    public function getData($ip = null)
    {
        if (is_null($ip)) {
            throw new \LogicException('No ip provided for LocationDataSource');
        }
        $query = http_build_query(['ip' => $ip]);
        $url = $this->baseUrl . '?' . $query;

        $data = unserialize($this->httpClient->getData($url));

        return $this->dataFactory->createDataBlock($data);
    }
}
 