<?php

namespace PresentData;

use Helpers\BeaufortCalculator;
use Location\Station;

class PresentDataProvider
{
    private $source;
    private $beaufortCalculator;

    public function __construct(BeaufortCalculator $beaufortCalculator)
    {
        $this->beaufortCalculator = $beaufortCalculator;
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
        $shortMsg = ($data->weergegevens->verwachting_meerdaags->tekst_middellang);
        $longMsg = $data->weergegevens->verwachting_vandaag->formattedtekst;
        if (empty($weerstations)) {
            return false;
        }
        foreach ($weerstations as $weerstation) {
            if ($weerstation->stationcode == $buienradarId) {
                return $this->toWeatherData($weerstation, $shortMsg, $longMsg);
            }
        }
    }

    private function toWeatherData($data, $shortMsg, $longMsg)
    {
        $id = substr($data->stationcode, 1, 3);
        $date = new \DateTime($data->datum);
        $temp = floatval(round($data->temperatuurGC, 1));
        $windSpeed = intval(round($data->windsnelheidMS * 3.6));
        $beaufort = $this->beaufortCalculator->getBeaufort($windSpeed);
        $windDirection = intval(round($data->windrichtingGR));
        $rain = floatval(round($data->regenMMPU, 1));
        $sight = intval(round($data->zichtmeters));
        if ($data->regenMMPU === '-') {
            $rain = 0;
        }
        return new PresentWeatherData(
            $date,
            $windDirection,
            $windSpeed,
            $beaufort,
            $id,
            $temp,
            $rain,
            $sight,
            $shortMsg,
            $longMsg
        );
    }

}
 