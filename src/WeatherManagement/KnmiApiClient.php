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
     * @return string
     */
    public function getData() {
        $data = $this->getXmlFromUrl($this->url);
        if(!empty($data['data']['location']['block'])) {
            foreach($data['data']['location']['block'] as $block) {
                if($block['field_id'] == 'Verwachting') {
                    return $block['field_content'];
                }
            }
        }
        throw new \RuntimeException('Unable to retrieve data from knmi API');
    }

} 