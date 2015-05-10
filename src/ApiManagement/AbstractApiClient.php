<?php

namespace ApiManagement;


abstract class AbstractApiClient implements ApiClient {

    protected function hasConfigFields(array $fields, array $config) {
        foreach($fields as $field) {
            if(!array_key_exists($field, $config)) {
                return false;
            }
        }
        return true;
    }

    protected function getXmlFromUrl($url) {
        $contents = @file_get_contents($url);
        if(empty($contents)) {
            throw new \RuntimeException('Unable to retrieve data from: ' . $url);
        }
        $json = json_encode(simplexml_load_string($contents));
        return json_decode($json, true);
    }

} 