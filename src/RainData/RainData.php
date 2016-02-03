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

    public function printData()
    {
        $this->printAsJsVar('data', array_values($this->rainMapping));
    }

    public function printLabels()
    {
        $this->printAsJsVar('labels', array_keys($this->rainMapping));
    }

    private function printAsJsVar($var, array $data)
    {
        echo 'var ' . $var . ' = ' . json_encode($data) . ';';
    }
}
 