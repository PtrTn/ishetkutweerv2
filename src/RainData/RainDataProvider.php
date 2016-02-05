<?php

namespace RainData;

use Location\LocationDataBlock;
use Location\Station;

class RainDataProvider
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://gps.buienradar.nl/getrr.php';
    }

    public function getDataByStation(Station $station)
    {
        return $this->getDataByLocation($station->getLocation());
    }

    public function getDataByLocation(LocationDataBlock $location)
    {
        $parameters = [
            'lat' => $location->getLat(),
            'lon' => $location->getLon()
        ];
        $query = http_build_query($parameters);
        $rainData = file_get_contents($this->baseUrl . '?' . $query);
        return $this->toDataObject($rainData);
    }

    private function toDataObject($data)
    {
        $pattern = '/(\d{3})\|(\d{2}\:\d{2})/m';
        $count = preg_match_all($pattern, $data, $matches);
        $rainData = new RainData();
        for ($i = 0; $i < $count; $i++) {
            $amount = $matches[1][$i];
            $time = $matches[2][$i];
            $rainData->addRain($time, $amount);
        }
        return $rainData;
    }
}
 
