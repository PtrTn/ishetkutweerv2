<?php

namespace HttpClients;

use GuzzleHttp\Client;
use Interfaces\HttpClient;

class GuzzleClient implements HttpClient
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getData($url)
    {
        return $this->client->get($url)->getBody();
    }
}
 