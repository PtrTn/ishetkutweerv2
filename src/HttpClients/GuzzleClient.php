<?php

namespace HttpClients;

use GuzzleHttp\Client;
use Interfaces\CacheProvider;
use Interfaces\HttpClient;

class GuzzleClient implements HttpClient
{
    private $client;
    private $cacheProvider;

    public function __construct(Client $client, CacheProvider $cacheProvider)
    {
        $this->client = $client;
        $this->cacheProvider = $cacheProvider;
    }

    public function getData($url, $useCache = false)
    {
        // Use cache data if available, allowed and not expired
        if ($useCache === true) {
            $data = $this->cacheProvider->getCache($url);
            if ($data !== false) {
                return $data;
            }
        }

        // Otherwise retrieve new data
        $data = $this->client->get($url)->getBody()->getContents();
        $this->cacheProvider->setCache($url, $data);
        return $data;
    }
}
 