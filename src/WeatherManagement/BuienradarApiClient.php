<?php

namespace WeatherManagement;

use ApiManagement\AbstractApiClient;

/**
 * Class BuienradarApiClient
 * @package WeatherManagement
 */
class BuienradarApiClient extends AbstractApiClient {

    /**
     * @var
     */
    private $url;

    /**
     * @param array $config
     */
    public function __construct(array $config) {
        if (!$this->hasConfigFields(
            array(
                'url',
            ),
            $config)) {
            throw new \InvalidArgumentException('Not all required fields have been specified in Buienradar-config');
        }
        $this->url = $config['url'];
    }

    /**
     * @return mixed
     */
    public function getData() {
        $data = $this->getXmlFromUrl($this->url);
        if(empty($data['weergegevens']['verwachting_vandaag']['formattedtekst'])) {
            return false;
        }
        return $data['weergegevens']['verwachting_vandaag']['formattedtekst'];
    }

} 