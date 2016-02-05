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
            $data['geoplugin_latitude'],
            $data['geoplugin_longitude']
        );
    }

    private function isValid($data)
    {
        if (empty($data)) {
            return false;
        }
        if (empty($data['geoplugin_latitude'])) {
            return false;
        }
        if (empty($data['geoplugin_longitude'])) {
            return false;
        }
        return true;
    }
}
 