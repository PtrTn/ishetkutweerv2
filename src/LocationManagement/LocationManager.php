<?php

namespace LocationManagement;


use ApiManagement\ApiClient;

class LocationManager {

    private $apiClient;

    public function __construct(ApiClient $apiClient) {
        $this->apiClient = $apiClient;
    }

    public function getLocation() {
        return $this->apiClient->getData();
    }

} 