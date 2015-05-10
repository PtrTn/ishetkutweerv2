<?php

namespace LocationManagement;


use ApiManagement\ApiClient;

class LocationManager {

    private $apiClient;

    public function __construct(ApiClient $apiClient) {
        $this->apiClient = $apiClient;
    }

    public function getLocation() {
        // Debug only
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == '::1') {
            $ip = '213.34.237.15';
        }
        return $this->apiClient->getData(['ip' => $ip]);
    }

} 