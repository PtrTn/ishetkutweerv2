<?php

namespace LocationManagement;

use ApiManagement\AbstractApiClient;

class IpinfodbApiClient extends AbstractApiClient
{
    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $apikey;

    /**
     * @var
     */
    private $format;

    /**
     * @param array $config
     */
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

    /**
     * @param bool $input
     * @return mixed
     */
    public function getData($input = false)
    {
        if($input === false) {
            return false;
        }

        $parameters = array(
            'key' => $this->apikey,
            'ip' => $input['ip'],
            'format' => $this->format
        );
        $parsedUrl = $this->url . '?' . http_build_query($parameters);
        $contents = file_get_contents($parsedUrl);
        return json_decode($contents);
    }

} 