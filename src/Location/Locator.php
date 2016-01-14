<?php

namespace Location;

class Locator
{
    private $locationServer;

    public function __construct()
    {
        $this->locationServer = 'http://www.geoplugin.net/php.gp?ip=';
    }

    public function getLocation($ip)
    {
        $geodata = unserialize(file_get_contents($this->locationServer . $ip));
        if(isset($geodata['geoplugin_latitude']) && isset($geodata['geoplugin_longitude'])) {
            return new Location($geodata['geoplugin_latitude'], $geodata['geoplugin_longitude']);
        }
        return false;
    }
}
 