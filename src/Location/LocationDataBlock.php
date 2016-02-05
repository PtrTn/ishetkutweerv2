<?php

namespace Location;

class LocationDataBlock
{
    private $lat;
    private $lon;

    public function __construct($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
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
 