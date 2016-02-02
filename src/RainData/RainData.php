<?php

namespace RainData;

class RainData
{
    private $rainMapping;

    public function __construct()
    {
        $this->rainMapping = [];
    }

    public function addRain($time, $amount)
    {
        $this->rainMapping[$time] = $amount;
    }
}
 