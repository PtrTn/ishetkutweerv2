<?php

namespace Station;

use Location\LocationDataBlock;

class Station
{
    private $knmiId;
    private $buienradarId;
    private $name;
    private $location;

    public function __construct($knmiId, $buienradarId, $name, $lat, $lon)
    {
        $this->knmiId = $knmiId;
        $this->buienradarId = $buienradarId;
        $this->name = $name;
        $this->location = new LocationDataBlock($lat, $lon);
    }

    public function toArray()
    {
        return
        [
            'latitude' => $this->location->getLat(),
            'longitude' => $this->location->getLon(),
            'station' => $this
        ];
    }

    public function getBuienradarId()
    {
        return $this->buienradarId;
    }

    public function getKnmiId()
    {
        return $this->knmiId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getSlug()
    {
        $slug = str_replace(' ', '-', $this->name);
        return strtolower($slug);
    }
}
 