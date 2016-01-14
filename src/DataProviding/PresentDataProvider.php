<?php

namespace DataProviding;

use Location\Station;

class PresentDataProvider
{
    private $source;

    public function __construct()
    {
        $this->source = 'http://xml.buienradar.nl/';
    }

    public function getData()
    {
        $xml = file_get_contents($this->source);
        if(isset($xml) && !empty($xml)) {
            $json = json_encode(simplexml_load_string($xml));
            return json_decode($json);
        }
        return false;
    }

    public function getDataByStation(Station $station)
    {
        $buienradarId = $station->getBuienradarId();
        $data = $this->getData();

        $weerstations = $data->weergegevens->actueel_weer->weerstations->weerstation;
        if (empty($weerstations)) {
            return false;
        }
        foreach ($weerstations as $weerstation) {
            if ($weerstation->stationcode == $buienradarId) {
                return $this->toWeatherData($weerstation);
            }
        }
    }

    private function toWeatherData($data)
    {
        $id = substr($data->stationcode, 1, 3);
        $date = date('d-m-Y', strtotime($data->datum));
        $temp = floatval(round($data->temperatuurGC, 1));
        $windSpeed = intval(round($data->windsnelheidMS * 3.6));
        $windDirection = intval(round($data->windrichtingGR));
        $rain = floatval(round($data->regenMMPU, 1));
        if ($data->regenMMPU === '-') {
            $rain = 0;
        }
        return new PresentWeatherData(
            $id,
            $date,
            $windSpeed,
            $windDirection,
            $temp,
            $rain
        );
    }

}
 