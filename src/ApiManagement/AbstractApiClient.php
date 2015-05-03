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

} 