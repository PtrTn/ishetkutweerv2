<?php

namespace Location;

use Interfaces\DataBlock;

class LocationDataBlock implements DataBlock
{
    private $lat;
    private $lon;
    private $city;

    public function __construct($lat, $lon, $city)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->city = $city;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function getlon()
    {
        return $this->lon;
    }
}
 