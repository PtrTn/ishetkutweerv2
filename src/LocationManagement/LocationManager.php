<?php

namespace LocationManagement;


class LocationManager {

    private $ipinfodbApiClient;

    public function __construct(IpinfodbApiClient $ipinfodbApiClient) {
        $this->ipinfodbApiClient = $ipinfodbApiClient;
    }

    public function getLocation() {
        return $this->ipinfodbApiClient->getData();
    }

} 