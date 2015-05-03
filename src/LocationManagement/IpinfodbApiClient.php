<?php

namespace LocationManagement;


class IpinfodbApiClient implements ApiClient {

    private $url;
    private $apiKey;
    private $format;

    public function __construct($config) {
        if(empty($config['apikey']) || empty($config['format']) || empty($config['url'])) {
            throw new \InvalidArgumentException('Not all required fields have been specified in IpInfoDb-config');
        }
        $this->apiKey = $config['apikey'];
        $this->url = $config['url'];
        $this->format = $config['format'];
    }

    public function getData() {

        // Debug only
        $ip = $_SERVER['REMOTE_ADDR'];
        if($ip == '::1') {
            $ip = '213.34.237.15';
        }

        $parameters = array(
            'key' => $this->apiKey,
            'ip' => $ip,
            'format' => $this->format
        );
        $parsedUrl = $this->url . '?' . http_build_query($parameters);
        $contents = file_get_contents($parsedUrl);
        return json_decode($contents);
    }

} 