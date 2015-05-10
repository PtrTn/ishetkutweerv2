<?php

namespace WeatherManagement;

use ApiManagement\AbstractApiClient;

class WundergroundApiClient extends AbstractApiClient {

    /**
     * @var
     */
    private $apikey;

    /**
     * @var
     */
    private $format;

    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $lang;

    /**
     * @param array $config
     */
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

    /**
     * @param mixed $input
     * @return mixed
     */
    public function getData($input = false) {
        if($input === false) {
            return false;
        }

        $query = $this->buildQuery($input);

        $parameters = array(
            'apikey' => $this->apikey,
            'features' => ['forecast10day', 'alerts', 'forecast'],
            'settings' => 'lang:' . $this->lang,
            'query' => $query,
            'format' => $this->format
        );
        $parsedUrl = $this->url . '/' . $parameters['apikey'] . '/' . implode('/', $parameters['features']) . '/' . $parameters['settings'] . '/q/' . $parameters['query'] . '.' . $parameters['format'];
        $contents = file_get_contents($parsedUrl);
        return json_decode($contents, true);
    }

    /**
     * @param $input
     * @return string
     */
    private function buildQuery($input) {
        if(empty($input['lat']) || empty($input['lon'])) {

            $ip = $_SERVER['REMOTE_ADDR'];
            if ($ip == '::1') {
                $ip = '213.34.237.15';
            }

            return 'autoip.json?geo_ip=' . $ip;
        }
        return $input['lat'] . ',' . $input['lon'];

    }

} 