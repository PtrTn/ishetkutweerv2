<?php

namespace Controllers;

use CurrentData\PresentDataBlock;

class BackgroundController
{

    public function getBackground(PresentDataBlock $dataBlock)
    {
        $temp = $dataBlock->getTemp();
        $rain = $dataBlock->getRain();
        $wind = $dataBlock->getBeaufort();
        $sight = $dataBlock->getSight();
        $dateTime = $dataBlock->getDate();
        return $this->getImageByData($temp, $rain, $wind, $sight, $dateTime);
    }

    private function getImageByData($temp, $rain, $wind, $sight, \DateTime $dateTime)
    {
        if ($temp < 0 && $rain > 0) {
            return 'snow.jpg';
        }
        if ($rain > 0.5) {
            return 'rain-2.jpg';
        }
        if ($rain > 0 && $rain <= 0.5) {
            return 'rain-1.jpg';
        }
        $nightStart = new \DateTime('23:00');
        $nightEnd = (new \DateTime('07:00'))->add(new \DateInterval('P1D'));
        if ($dateTime > $nightStart && $dateTime < $nightEnd) {
            return 'clear-night.jpg';
        }
        if ($sight < 1000) {
            return 'fog.jpg';
        }
        if ($wind > 7) {
            return 'wind-2.jpg';
        }
        if ($wind > 5) {
            return 'wind-1.jpg';
        }
        if ($temp > 20 && $rain == 0) {
            return 'clear-day-2.jpg';
        }
        if ($rain == 0) {
            return 'clear-day-1.jpg';
        }
        return 'default.jpg';
    }
}
 