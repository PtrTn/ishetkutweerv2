<?php

namespace PresentData;

use Interfaces\DataFactory;
use Station\Station;

class PresentDataFactory implements DataFactory
{
    public function createDataBlock($data, Station $station = null)
    {
        // Validate data
        $xml = simplexml_load_string($data);
        if (!$this->isValid($xml)) {
            throw new \RuntimeException('Invalid current weather data');
        }

        // Retrieve data from xml
        $stationData = $this->getStationData($xml, $station->getBuienradarId());
        $shortMsg = $this->getShortMsg($xml);
        $longMsg = $this->getLongMsg($xml);

        // Return DataBlock based on data
        return new PresentDataBlock(
            $station->getBuienradarId(),
            $stationData->datum,
            $stationData->temperatuurGC,
            $stationData->regenMMPU,
            $stationData->windsnelheidMS,
            $stationData->windrichtingGR,
            $stationData->zichtmeters,
            $shortMsg,
            $longMsg
        );
    }

    private function getStationData($xml, $stationId)
    {
        $weatherStation = $xml->xpath('//weerstations/weerstation[@id="' . $stationId . '"]');
        if (!isset($weatherStation)) {
            throw new \RuntimeException('No data found for weatherstation with id "' . $stationId . '"');
        }
        return reset($weatherStation);
    }

    private function getShortMsg($xml)
    {
        $shortMsg = trim($xml->weergegevens->verwachting_meerdaags->tekst_middellang->__toString());
        if (empty($shortMsg)) {
            throw new \RuntimeException('No data found for short weather message');
        }
        return $shortMsg;
    }

    private function getLongMsg($xml)
    {
        $longMsg = trim($xml->weergegevens->verwachting_vandaag->formattedtekst->__toString());
        if (empty($longMsg)) {
            throw new \RuntimeException('No data found for long weather message');
        }
        return $longMsg;
    }

    private function isValid(\SimpleXMLElement $xml)
    {
        // Check for weather data
        if (!isset($xml->weergegevens->actueel_weer->weerstations->weerstation)) {
            return false;
        }
        if (count($xml->weergegevens->actueel_weer->weerstations->weerstation) <= 0) {
            return false;
        }

        // Check for short message
        if (!isset($xml->weergegevens->verwachting_meerdaags->tekst_middellang)) {
            return false;
        }

        // Check for long message
        if (!isset($xml->weergegevens->verwachting_vandaag->formattedtekst)) {
            return false;
        }
        return true;
    }
}
 