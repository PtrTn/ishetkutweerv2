<?php

namespace WeatherManagement;

use ApiManagement\AbstractApiClient;

class WundergroundApiClient extends AbstractApiClient {

    private $apikey;
    private $format;
    private $url;
    private $lang;

    public function __construct(array $config) {
        if (!$this->hasConfigFields(
            array(
                'apikey',
                'format',
                'url',
                'lang'
            ),
            $config)) {
            throw new \InvalidArgumentException('Not all required fields have been specified in Wunderground-config');
        }
        $this->apikey = $config['apikey'];
        $this->format = $config['format'];
        $this->url = $config['url'];
        $this->lang = $config['lang'];
    }

    public function getData() {
        $parameters = array(
            'apikey' => $this->apikey,
            'features' => ['forecast10day', 'geolookup'],
            'settings' => 'lang:' . $this->lang,
            'query' => 'autoip.json?geo_ip=' . $_SERVER['REMOTE_ADDR'],
            'format' => $this->format
        );
        $parsedUrl = $this->url . '/' . $parameters['apikey'] . '/' . implode('/', $parameters['features']) . '/' . $parameters['settings'] . '/q/' . $parameters['query'] . '.' . $parameters['format'];
        $contents = file_get_contents($parsedUrl);
        return json_decode($contents, true);
    }

} 