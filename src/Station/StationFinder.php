<?php

namespace Station;

use JeroenDesloovere\Distance\Distance;
use Location\LocationDataBlock;

class StationFinder
{
    private $stationFactory;
    private $distanceCalc;

    public function __construct(StationFactory $stationFactory, Distance $distanceCalc)
    {
        $this->stationFactory = $stationFactory;
        $this->distanceCalc = $distanceCalc;
    }

    public function findStationByLocation(LocationDataBlock $location)
    {
        $stations = $this->stationFactory->getStations();
        $stationsArray = $this->stationsToArray($stations);
        $stationArray = $this->distanceCalc->getClosest($location->getLat(), $location->getLon(), $stationsArray);
        return $stationArray['station'];
    }

    public function findStationBySlug($slug)
    {
        $stations = $this->stationFactory->getStations();
        foreach ($stations as $station) {
            if ($station->getSlug() === $slug) {
                return $station;
            }
        }
        return null;
    }

    public function findStationById($id)
    {
        $stations = $this->stationFactory->getStations();
        foreach ($stations as $station) {
            if ($station->getBuienradarId() == $id) {
                return $station;
            }
        }
        return null;
    }

    private function stationsToArray(array $stations)
    {
        $stationsArray = [];
        foreach ($stations as $station) {
            $stationsArray[] = $station->toArray();
        }
        return $stationsArray;
    }

}
 