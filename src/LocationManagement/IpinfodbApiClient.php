<?php

namespace LocationManagement;

use ApiManagement\AbstractApiClient;

class IpinfodbApiClient extends AbstractApiClient
{

    private $url;
    private $apikey;
    private $format;

    public function __construct(array $config)
    {
        if (!$this->hasConfigFields(
            array(
                'apikey',
                'format',
                'url'
            ),
            $config)) {
            throw new \InvalidArgumentException('Not all required fields have been specified in IpInfoDb-config');
        }
        $this->apikey = $config['apikey'];
        $this->url = $config['url'];
        $this->format = $config['format'];
    }

    public function getData()
    {

        // Debug only
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == '::1') {
            $ip = '213.34.237.15';
        }

        $parameters = array(
            'key' => $this->apikey,
            'ip' => $ip,
            'format' => $this->format
        );
        $parsedUrl = $this->url . '?' . http_build_query($parameters);
        $contents = file_get_contents($parsedUrl);
        return json_decode($contents);
    }

} 