<?php

namespace ApiManagement;


use Importing\YamlImporter;

/**
 * Class ApiClientFactory
 * @package ApiManagement
 */
class ApiClientFactory
{

    /**
     * @param $name
     * @return mixed
     */
    public function getApiClient($name)
    {
        switch ($name) {
            case 'wunderground':
                $configFile = __DIR__ . '/../../app/config/wunderground.yml.dist';
                return new \WeatherManagement\WundergroundApiClient($this->getConfigParser($configFile)->getData());
                break;
            case 'buienradar':
                $configFile = __DIR__ . '/../../app/config/buienradar.yml.dist';
                return new \WeatherManagement\BuienradarApiClient($this->getConfigParser($configFile)->getData());
                break;
            case 'knmi':
                $configFile = __DIR__ . '/../../app/config/knmi.yml.dist';
                return new \WeatherManagement\KnmiApiClient($this->getConfigParser($configFile)->getData());
                break;
            case 'ipinfodb':
                $configFile = __DIR__ . '/../../app/config/ipinfodb.yml.dist';
                return new \LocationManagement\IpinfodbApiClient($this->getConfigParser($configFile)->getData());
                break;
            default:
                throw new \InvalidArgumentException('ApiClient not found ' . $name);
        }
    }

    /**
     * @param $configFile
     * @return YamlImporter
     */
    private function getConfigParser($configFile)
    {
        return new YamlImporter($configFile);
    }

} 