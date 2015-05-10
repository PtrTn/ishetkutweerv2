<?php

namespace WeatherManagement;

use ApiManagement\AbstractApiClient;

/**
 * Class KnmiApiClient
 * @package WeatherManagement
 */
class KnmiApiClient extends AbstractApiClient {

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
            throw new \InvalidArgumentException('Not all required fields have been specified in Knmi-config');
        }
        $this->url = $config['url'];
    }

    /**
     * @return mixed
     */
    public function getData() {
        $data = $this->getXmlFromUrl($this->url);
        if(empty($data['data']['location']['block'])) {
            return false;
        }
        foreach($data['data']['location']['block'] as $block) {
            if($block['field_id'] == 'Verwachting') {
                return $block['field_content'];
            }
        }
        return false;
    }

} 