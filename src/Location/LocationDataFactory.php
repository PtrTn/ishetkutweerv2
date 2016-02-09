<?php

namespace Location;

use Interfaces\DataFactory;

class LocationDataFactory implements DataFactory
{
    public function createDataBlock($data)
    {
        if (!$this->isValid($data)) {
            throw new \RuntimeException('No location data found');
        }
        return new LocationDataBlock(
            $data['latitude'],
            $data['longitude'],
            $data['city_name']
        );
    }

    private function isValid($data)
    {
        if (empty($data)) {
            return false;
        }
        if (empty($data['latitude'])) {
            return false;
        }
        if (empty($data['longitude'])) {
            return false;
        }
        if (empty($data['city_name'])) {
            return false;
        }
        return true;
    }
}
 