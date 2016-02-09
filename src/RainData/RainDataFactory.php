<?php

namespace RainData;

use Interfaces\DataFactory;

class RainDataFactory implements DataFactory
{
    public function createDataBlock($data)
    {
        $pattern = '/(\d{3})\|(\d{2}\:\d{2})/m';
        $count = preg_match_all($pattern, $data, $matches);
        $rainData = new RainDataBlock();
        for ($i = 0; $i < $count; $i++) {
            $amount = $matches[1][$i];
            $time = $matches[2][$i];
            $rainData->addRain($time, $amount);
        }
        return $rainData;
    }

}
 